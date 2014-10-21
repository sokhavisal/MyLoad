var RootPath	= '../';
var CurPath     = './data/';
var result_Done			= 'success';
var result_Fail			= 'error';
var msg_TitleDone		= '成功';
var msg_TitleFail		= 'エラー';
var msg_Prefix			= 'レコードを';
var msg_Add				= '追加';
var msg_Save			= '保存';
var msg_Delete			= '削除';
var msg_Logout			= 'ログアウト';
var msg_Confirm			= '\n\nよろしいでしょうか？';
var msg_Do				= 'します。';
var msg_Done			= 'しました。';
var msg_Failed			= 'できませんでした。';
var msg_Unsaved			= '保存されていない情報があります。';
var msg_Then			= 'すると、';
var msg_EdtLost			= '編集内容は失われます。';
var msg_Reload			= '再読み込み';
var msg_WantDo			= 'しますか？';
var msg_BackThen		= '戻ると、';
var msg_WantBack		= '戻りますか？';
var msg_Switch			= '移動';
var msg_SaveOrReload	= '\n\n先に「保存」または「リロード」してください。';
var msg_MultiDelete		= '\n\n(一部レコードは削除できない場合があります。)';

var msg_LogoutConfirm =	msg_Logout+msg_Do+msg_Confirm;
var msg_SaveConfirm =	msg_Prefix+msg_Save+msg_Do+msg_Confirm;
var msg_AddDone =		msg_Add+msg_Done;
var msg_AddFailed =		msg_Add+msg_Failed;
var msg_SaveDone =		msg_Save+msg_Done;
var msg_SaveFailed =	msg_Save+msg_Failed;
var msg_DeleteConfirm =	msg_Prefix+msg_Delete+msg_Do+msg_Confirm;
var msg_MultiDelConfirm = msg_Prefix+msg_Delete+msg_Do+msg_MultiDelete+msg_Confirm;
var msg_DeleteDone =	msg_Delete+msg_Done;
var msg_DeleteFailed =	msg_Delete+msg_Failed;

var msg_ReloadConfirm =	msg_Unsaved+'\n'+msg_Reload+msg_Then+msg_EdtLost+'\n\n'+msg_Reload+msg_WantDo;
var msg_BackConfirm =	msg_Unsaved+'\n'+msg_BackThen+msg_EdtLost+'\n\n'+msg_WantBack;
var msg_SwitchConfirm =	msg_Unsaved+'\n'+msg_Switch+msg_Then+msg_EdtLost+'\n\n'+msg_Switch+msg_WantDo;
var msg_ChangedAlert =	msg_Unsaved+msg_SaveOrReload;

var ERROR_FROMTO_DATE	= "日付の範囲が無効です。";
var ERROR_FROMTO_NUM	= "入力数値が無効です。";
var ERROR_DATE			= "入力された日付が不正です。";
var ERROR_EDIT			= "不正値があるため処理を終了します。";
var MSG_SORTPolic		= "保存されていない情報があります。\n情報を切り替えてもよろしいでしょうか？";
var MSG_SESSIONOUT		= "セッション切れです。強制ログアウトします。";

/**
 * セッション確認
 * ヘッダ領域のhtmlを取得し、403が帰ってきたらセッション切れと判断
 * @param event object イベントオブジェクト
 * @returns boolean セッション状態 true:持続 false:切断
 */
function CheckSession(event) {
	var result;
	$.ajax({
		url: RootPath+'header.php',
		async: false
	}).fail(function(xhr,status,error) {
		result = false;
		if (xhr.status === 403 || xhr.status === 500) {
			if (typeof(event) !== 'undefined') {
				if (typeof(event.preventDefault) === 'function') { event.preventDefault(); }
			}
			document.body.innerHTML = '';
			alert("セッション切れです。強制ログアウトします。");
			document.location = RootPath+'logout.php';
		}
	}).done(function(data,status,xhr) {
		result = true;
	});
	return result;
};

/**
* オブジェクト挿入グリッド変更処理
* ［備考］
* 　W2UI形式のデータに変換する。
* @param obj　RowData　レコード配列
* @return obj	変換後レコード配列
*/
function objChenge(obj,event) {
	var undefined;
	//イベント情報にカラム名が存在する場合
	if(event.column !== undefined){

		var targetOBJ=$('#grid_'+obj.name+'_rec_'+event.recid+' .w2ui-grid-data[col='+event.column+']');
		var objInput=targetOBJ.find('input');
		var objSelect=targetOBJ.find('option');
		var objTextarea=targetOBJ.find('textarea');

		//対象オブジェクトが存在しない場合は、処理を抜ける
		if(objInput.length + objSelect.length + objTextarea.length == 0) return;
		var colname=obj.columns[event.column].field;
		
		var val={},i,htmlTag={};
		if(objInput.length>0) {
			switch (objInput[0].type){
				case 'text':
					val[colname] = objInput[0].value;
					htmlTag[colname]=targetOBJ.find('div').html();
					break;
				case 'radio':
					for (i = 0; i < objInput.length; i = i +1){
						var dbg=objInput.eq(i);
						if(dbg[0].checked){ 
							val[colname] = dbg[0].value;
						}
					}
					//修正後のタグを取得
					//htmlTag[colname]=record[colname];
					htmlTag[colname]=targetOBJ.find('div').html();
					break;					
				case 'checkbox':
					for (i = 0; i < objInput.length; i = i +1){
						var dbg=objInput.eq(i);
						if(dbg[0].checked){ 
							dbg.attr("checked",true);
							if(val[colname]){
								val[colname] = val[colname]+dbg[0].value;
							} else {
								val[colname] = dbg[0].value+"\n";
							}
						} else {
							dbg.attr("checked",false);
							//val[colname] = '';
						}
					}
					//修正後のタグを取得
					htmlTag[colname]=targetOBJ.find('div').html();
					if(htmlTag[colname] === undefined){
						htmlTag[colname]=targetOBJ.html();
					}
					break;
			}
		} else if(objSelect.length>0) {
				for (i = 0; i < objSelect.length; i = i +1){
					var dbg=objSelect.eq(i);
					if(dbg[0].selected){ 
						val[colname] = dbg[0].value;
						dbg.attr("selected",true);
					} else {
						dbg.attr("selected",false);
					}
				}
				//修正後のタグを取得
				htmlTag[colname]=targetOBJ.find('div').html();
				if(htmlTag[colname] === undefined){
					htmlTag[colname]=targetOBJ.html();
				}				
		} else if(objTextarea.length>0) {

			val[colname] = objTextarea.val();
			//修正後のタグを取得
			htmlTag[colname]=objTextarea[0].outerHTML.replace(objTextarea.html(),objTextarea.val());
		}
		var rowpos=getRowNo(obj.name,event.recid);

		//変更があったか確認
		if(obj.records[rowpos]['_bTag'][colname] != val[colname]) {
			//変更があった場合に、クラスとフラグを設定する
			obj.records[rowpos]['changed']=true;
			targetOBJ.addClass('w2ui-changed');
		} else {
			//変更が無かった場合に、クラスを削除し入力値変数をクリア
			targetOBJ.removeClass('w2ui-changed');
			val={};
		}

		//すでに変更データがある場合
		var change =obj.records[rowpos]['changes'];
		if(change !== undefined){
			$.each(change, function(key, value) {
				htmlTag[key] = value;
			});
		}
		var changedb =obj.records[rowpos]['_cTag'];
		cTag={};
		if(changedb !== undefined){
			$.each(changedb, function(key, value) {
				if(val[key] === undefined && colname != key && obj.records[rowpos]['_bTag'][key] !== value){
					cTag[key] = value;
				}
			});
		}

		//前処理での変更分に、現在の変更データを付加する。
		if(val !== undefined){
			$.each(val, function(key, value) {
				if(colname == key && obj.records[rowpos]['_bTag'][key] !== value){
					cTag[key] = value;
				}
			});
		}

		//実数を別配列に保存
		obj.records[rowpos]['_cTag']=cTag;
		//変更されたタグを保存
		obj.records[rowpos]['changes']=htmlTag;
	}
}
/**
* 列番号取得
* @param str	t　グリッド名
* @param str	c　列名
* @return int	列番号　
*/
function getColNo(t,c) {
	for (var i=0;i<w2ui[t].columns.length;i++) {
		if(w2ui[t].columns[i].field == c) {return i;}
	}
}
/*
* テキストエリアのフォーカス
* ［備考］
* 　フォーカス時にクラス追加＆文章選択
* @param obj　テキストエリアオブジェクト
*/
function textareafocus(obj) {
	$(obj).addClass('tAreafocus');
}
/**
* テキストエリアのロストフォーカス
* ［備考］
* 　クラス削除
* @param obj　テキストエリアオブジェクト
*/
function textareablur(obj) {
	$(obj).removeClass('tAreafocus');
	textareaResize(obj);
}
/**
* String日付をDate型に変換
* ［備考］
* 　全角文字列は半角に変換し型変換する。
*   不正な日付を入力した場合、強制変換する。
* @param string Str 日付文字列
* @return Date　
*/
function StrToDate(arrayObj,name) {

	if(!arrayObj[name])return 0;

	arrayObj[name] = arrayObj[name].replace(/-/g, '/').replace(/／/g, '/')
			.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
				return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);});

	var Rec=null;
	if(w2utils.isDate(arrayObj[name], 'yyyy/mm/dd')) {
		//日付を半角にし、区切りを/で統一する
		var cDate =new Date(arrayObj[name]);
		var y = cDate.getFullYear();
		var m = cDate.getMonth() + 1;
		var d = cDate.getDate();
		m = ('0' + m).slice(-2);
		d = ('0' + d).slice(-2);
		arrayObj[name] = y +  '/'  + m +  '/'  + d;
		Rec=Date.parse(arrayObj[name]);
	}
    return 	Rec;
}
/**
* 全角文字列を半角に変換
* @param string Str　文字列
* @return string
*/
function JLower(Str) {
	return Str.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
		return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
	});
}
/**
* 半角文字列を全角に変換
* @param string Str　文字列
* @return string
*/
function JUpper(Str) {
	return Str.replace(/[A-Za-z0-9]/g, function(s) {
		return String.fromCharCode(s.charCodeAt(0) + 0xFEE0);
	});
}
/**
* テキストエリアのリサイズ
* ［備考］
* 　入力行数で高さをリサイズする。
* @param event
*/
function textareaResize(event) {
     var text = $(event.target).val(),
            // look for any "\n" occurences
            matches = text.match(/\n/g),
            breaks = matches ? matches.length : 1;
        $(event.target).attr('rows',breaks + 1);
}
/**
* 行番号取得
* @param str	t　グリッド名
* @param str	r　recid
* @return int	行配列番号
*/
function getRowNo(t,r) {
	for (var i=0;i<w2ui[t].records.length;i++) {
		if(w2ui[t].records[i].recid == r) {return i;}
	}
}
/**
* オブジェクト属性取得
* @param str	t　attributes
* @return str	列番号
*/
function getAttributes(t) {
	var rec = '';
	for (var i=0;i<t.length;i++) {
		rec += t[i].name+'="'+t[i].value+'" ';
	}
	return rec;
}
/**
* Jsonデータ取得
* @param url	string  JSON取得URL
* @param prm	string  POSTパラメータ
* @param typ	string  POST/GET
* @return JSONデータ
*/
function getJSON(url, prm, typ) {
	var p = (prm) ? prm : '';
	var t = (typ) ? typ : 'POST';
	var list = {};

	if(t == 'POST') {
		$.ajax({
			async  : false,
			type   : t,
			url    : url,
			data	:p
		}).done(function(msg) {
			var result = $.parseJSON(msg);
			if (result.status === result_Done) {
				if (result.nodes) {
					list = result.nodes;
				} else if (result.items) {
					list = result.items;
				} else {
					list = result;
				}
			} else {
				w2ext.alertIcon = w2ext.icons.error;
				w2ext.alert(result.message);
			}
		});
	} else {
		$.ajax({
			async  : false,
			type   : t,
			url    : url + p
		}).done(function(msg) {
			var result = $.parseJSON(msg);
			if (result.status === result_Done) {
				if (result.nodes) {
					list = result.nodes;
				} else if (result.items) {
					list = result.items;
				} else {
					list = result;
				}
			} else {
				w2ext.alertIcon = w2ext.icons.error;
				w2ext.alert(result.message);
			}
		});
	}

	return list;
}
/**
 * w2ui.gridオブジェクトにカスタムファンクションを追加する
 *  使い方：
 *  　w2ui.grid定義の初期化時処理(onRender)で、
 *  　　onRender: function(event) {
 *           w2grid_AppendCustomFunctions(this);
 *      }
 * 　 とする。
 * @param obj object w2ui.gridオブジェクト
 * @returns {Boolean}
 */
function w2grid_AppendCustomFunctions(obj) {
	if (typeof(obj) !== 'object') { return false; }
	var undefined;
	obj.IsRender=true;

	/**
	 * インライン編集されたレコードがあるか調べる
	 * @returns {Boolean}
	 */
	obj.IsChanged = function() {
		this.DeleteDummyChange();
		var change = this.getChanges();
		this.AddDummyChange();
		return (change.length>0);
	};
	/**
	 * 読み込まれたレコードのタグを解析する
	 */	
	obj.on('load',function(target, eventData) {
		this['flgDblClick'] = false;
		this['EditMode'] = $.extend(true, {}, { Edit: false, recid: 0, column: 0 });
		//console.log(eventData);

		eventData.onComplete = function() {
			eventData.isCancelled = true;
			
			//デフォルトでは、検索ヒット文字にマークが付けられるが
			//入力オブジェクトではタグが見えてしまうため内部検索値を削除する。
			//$('#grid_'+ this.name +'_search_all').val(this.last.search);
			this.last.search='';
			//ここまで　将来的には、グリッドの設定値でマーク/非マークに対応する。

			this.AddDummyChange();	  //ダミー変更データ埋め込み
			this.initColumnOnOff();
			for (var i=0;i<this.records.length;i++) {
				var rec = this.records[i];
				$.each(rec, function(key, val) {
					//HTMLタグか判別する
					if(String(val).match(/[<(.*)>.*<\1>]/) != null && String(val).substring(0,1) == '<'){
						//タグ文字列をオブジェクトに変換
						var d = $(val);
						//タグの種類別に値を抽出し、イベントを追加
						switch (d[0].nodeName){
							case 'SELECT':
								 for (var i=0;i<d[0].length;i++) {
									 if(d[0][i].selected) {
										 var tag={};
										 tag[key]=d[0][i].value;
										 rec._bTag = $.extend(true, tag, rec._bTag);
									 }
								 }
								if(val.toLowerCase().indexOf('onchange') < 0){
									rec[key] = '<select ' +getAttributes(d[0].attributes)+'onchange="objChenge(w2ui.'+target+',{recid:'+rec['recid']+',column:'+getColNo(target,key)+'});">';
									for(var p=0;p<d[0].length;p++){
										rec[key]+='<option '+getAttributes(d[0][p].attributes)+'>'+d[0][p].textContent+'</option>';
									}
									rec[key] += '</select>';
								}
								break;
							case 'INPUT':
								switch (d[0].type){
									case 'text':
										 var tag={};
										 tag[key]=d[0].value;
										 rec._bTag = $.extend(true, tag, rec._bTag);
										 if(val.toLowerCase().indexOf('onchange') < 0){
											rec[key]='<input '+getAttributes(d[0].attributes)+'onchange="objChenge(w2ui.'+target+',{recid:'+rec['recid']+',column:'+getColNo(target,key)+'});"> ';
										 } 
										break;
									case 'radio':
										var tag={};
										if(val.indexOf('checked')>0){
											tag[key]=$(val).filter(':checked').val();
										}else {
											tag[key]='';
										}
										rec._bTag = $.extend(true, tag, rec._bTag);
										if(val.toLowerCase().indexOf('onchange') < 0){
											rec[key]='';
											for(var p=0;p<d.length;p++){
												if(d[p].type != undefined) {
													rec[key]+='<input '+getAttributes(d[p].attributes)+'onchange="objChenge(w2ui.'+target+',{recid:'+rec['recid']+',column:'+getColNo(target,key)+'});"> ';
												} else {
													rec[key] += d[p].data;
												}
											}
										}
										break;
									case 'checkbox':
										var tag={};
										tag[key]='';
										rec._bTag = $.extend(true, tag, rec._bTag);
										for (var ii=0;ii<d.length;ii++) {
											if(d[ii].checked) {
												tag[key]=d[ii].value+"\n";
												rec._bTag = $.extend(true, tag, rec._bTag);
											}
										}
										if(val.toLowerCase().indexOf('onchange') < 0){
											rec[key]='';
											for(var p=0;p<d.length;p++){
												if(d[p].type != undefined) {
													rec[key]+='<input '+getAttributes(d[p].attributes)+'onchange="objChenge(w2ui.'+target+',{recid:'+rec['recid']+',column:'+getColNo(target,key)+'});"> ';
												} else {
													rec[key] += d[p].data;
												}
											}
										}
										break;
								}
								break;
							case 'TEXTAREA':
								var tag={};
								d.css({'width':'100%','border':'0px'});
								tag[key]=d[0].value;
								rec._bTag = $.extend(true, tag, rec._bTag);
								if(val.toLowerCase().indexOf('onchange') < 0){
								   rec[key]='<textarea '+getAttributes(d[0].attributes)+
									   'onchange="textareaResize(event);objChenge(w2ui.'+target+',{recid:'+rec['recid']+',column:'+getColNo(target,key)+'});" '+
									   'onfocus="textareafocus(this);" '+
									   'onblur="textareablur(this);" '+
									   '>'+d[0].textContent+'</textarea>';
								}
								break;
						}
					}
				});
			}
		};
	});
	
	/**
	 * クリックイベント
	 */	
	obj.on('click',function(target, eventData) {
		if (this['EditMode'].recid !== eventData.recid || this['EditMode'].column !== eventData.column) {
			this['EditMode'] = $.extend(true, {}, { Edit: false, recid: 0, column: 0 });
		}
		if (this['EditMode'].Edit) {
			eventData.preventDefault();
		}
	});	
	/**
	 * ダブルクリックイベント
	 */	
	obj.on('dblClick',function(target, eventData) {
		this['flgDblClick'] = true;
		this['EditMode'] = $.extend(true, {}, { Edit: true, recid: eventData.recid, column: eventData.column});
	});
	/**
	 * saveイベント
	 * 変更データが存在しない場合は、イベントキャンセルする。
	 */	
	obj.on('save',function(target, eventData) {
//w2ui1.4.1用
//		var changes = this.getChanges();
//		if (changes.length > 0) {
		if (eventData.changed.length>0) {			//eventData.isCancelled = true;
			//通常処理に影響するため、削除
		} else {
			eventData.preventDefault();
			eventData.isStopped =true;
		}
	});
	/**
	 * selectイベント
	 * 変更データが存在しない場合は、イベントキャンセルする。
	 */
	obj.on('select',function(target, eventData) {
		// ダブルクリックから来た場合＆エディット中は処理しない。
		if (!this['flgDblClick'] && !this['EditMode'].Edit) {
			eventData.onComplete = function(eventData) {
				eventData.preventDefault();
			};
		}
		this['flgDblClick'] = false;
	});	
	/**
	 * オブジェクト値抽出関数
	 * イベント配列のchanged項目を、変更値に置き換える
	 * 
	 * @param	string	target	ターゲットOBJ名
	 * @param	string	eventData	イベントデータ
	 * @returns	無し
	 */
	obj.cnvObj = function(target, eventData) {
		for (i = 0; i < eventData.changed.length; i = i +1){
			var cnv=GetRowData(w2ui[target].get(eventData.changed[i].recid));
			eventData.changed[i] = cnv;
		}
	};
//w2ui1.4.1用	
/*	obj.cnvObj = function(target, changes) {
		for (i = 0; i < changes.length; i = i +1){
			var cnv=GetRowData(w2ui[target].get(changes[i].recid));
			changes[i] = cnv;
		}
	};
*/	/**
	 * インライン編集されたレコードがあるか調べ、ある場合はメッセージを表示
	 * @returns {Boolean}
	 */
	obj.CheckChanged = function() {
		if (this.IsChanged()) {
			w2ext.alertIcon = w2ext.icons.exclamation;
			w2ext.alert("保存されていない情報があります。\n\n先に‘保存’または‘リロード’してください。");
//			alert("保存されていない情報があります。\n\n先に‘保存’または‘リロード’してください。");
			return true;
		} else {
			return false;
		}
	};

	/**
	 * ダミー変更データ埋め込み
	 * インライン編集で手動で元の値に戻された(例:100→1000とした後、100に戻す)とき、
	 * 他に変更箇所が無ければ、this.records.changesオブジェクトが除去され、FireFoxでw2ui内でエラーとなる
	 * これを回避する(changesオブジェクトを除去させない)ため、
	 * 事前にダミーのメンバー変数をchangesオブジェクトにセットしておく
	 * @returns {undefined}
	 */
	obj.AddDummyChange = function() {
		for (var i=0;i<this.records.length;i++) {
		var rec = this.records[i];
			rec.changes = $.extend(true, {'_dummy':''}, rec.changes);
		}
	};

	/**
	 * ダミー変更データ除去
	 * this.records.changesオブジェクトにセットされているダミーのメンバー変数を除去する
	 * 除去した結果、chengesオブジェクトが空になった場合は、chengesオブジェクトとchangedオブジェクトを除去
	 * @returns {undefined}
	 */
	obj.DeleteDummyChange = function() {
		for (var i=0;i<this.records.length;i++) {
			var rec = this.records[i];
			if (rec.changes) {
				delete rec.changes['_dummy'];
				var cnt = 0;
				for (var key in rec.changes) { cnt++; }
				if ( cnt === 0 ) { delete rec.changes; delete rec.changed; }
			}
		}
	};

	/**
	* カラムサイズ変更データ保持
	* @param	string	field	列幅を変更したfield名
	* @returns	string			変更後のカラムサイズ
	*/
	obj.ColumnResize = function(field) {
		var size = 0;
		for (var i = 0; i < this.columns.length; i++) {
			if (this.columns[i].field == field) {
				size = this.columns[i].size;
				break;
			}
		}
		return size;
	};
	/**
	* 検索リロード
	* @param	string	field	検索対象field名
	* @param	string	key		検索キー
	* @return					なし
	*/
	obj.SearchReload = function(field,key) {
		var searchKeys={};
		if(key.length > 0) {
			searchKeys['field']=field;
			searchKeys['operator']='contains';
			searchKeys['type']='text';
			searchKeys['value']=key;
			obj.searchData[0] = searchKeys;
			obj.reload();
			obj.searchData={};
		} else {
			obj.searchData={};
			obj.reload();
			
		}
	};	
	return true;
}

/**
* オブジェクト挿入グリッド通常形式変換
* ［備考］
* 　W2UI形式のデータに変換する。
* @param obj　RowData　レコード配列
* @return obj	変換後レコード配列
*/
function GetRowData(RowData) {
	if (undefined != RowData['_bTag']) {
		var rec = {}; 
		var i;
		//タグ設定修正フィールド名の取得
		var TagData={};
		var TagCnt=0;

		$.each(RowData['_bTag'], function(key, val) {
			TagData[TagCnt]=key;
			TagCnt++;
		});
		//行データの作成
		$.each(RowData, function(key, val) {
			for (i = 0; i < TagCnt; i++){
				if(TagData[i]==key){
					val=RowData['_bTag'][key];
				}
			}
			if(key != '_bTag' && key != 'changed' && key != 'changes' && key != '_cTag' && key != 'selected'){
				rec[key] = val;
			}
		});
		var changes = {};
		$.each(RowData.changes, function(key, val) {
			for (i = 0; i < TagCnt; i++){
				if(TagData[i]==key){
					val=RowData['_cTag'][key];
				}
			}
			changes[key] = val;
		});
		rec['changes']=changes;
	}
	return rec;
}

// フォーム共通部定義
var fCommon = {
	parentGrid: '',
	actions: {
		'閉じる': function () {
			w2popup.close();
		},
		'クリア': function () {
			this.clear();
		},
		'保存': function () {
			// テキスト入力項目のタグ＆前後空白除去
			var cRec = this.record;
			for (var i in cRec) {
				if (typeof(cRec[i]) === 'string') {
					cRec[i] = w2utils.stripTags(cRec[i]);
				}
			}
			this.refresh();
			
			// 必須チェック
			var errors = this.validate();
			if (errors.length > 0) return;

			// 保存確認
			var parent = this.parentGrid;
			var obj = this;
			w2ext.confirm(msg_SaveConfirm, function(btn) {
				if (btn === w2ext.buttons.Yes) {
					// 保存実行
					obj.save({}, function(result) {
						if (result.status === result_Done) {
							if (parent !== '' & typeof(w2ui[parent]) === 'object') {
								w2ui[parent].skip(0);	   // 追加後、グリッドのoffset値を0に戻す
							}
							w2ext.alertIcon = w2ext.icons.accept;
							w2ext.alert(msg_SaveDone, function() {
								w2popup.close();
							});
						} else {
							w2ext.alertIcon = w2ext.icons.error;
							w2ext.alert(result.message);
						}
					});
				}
			});
		}
	},
	onSubmit: function(event) {
		// w2ui.form内部処理で日付が不正になるので、改めて設定する
		var param = event.postData.record;
		$.extend(true, param, this.record);
		// 送信データのテキスト項目の値をタグエンコードする
		for (var i in param) {
			if (typeof(param[i]) === 'string') {
				param[i] = w2utils.encodeTags(param[i]);
			}
		}

		// セッション確認
		if (!CheckSession(event)) return;
	},
	onError: function(event) {
		//　w2ui内部処理のエラー表示を行わない。
		event.preventDefault();
	}
};


//グリッド共通部定義
var gCommon = {
	show: {
		header:true,
		toolbar:true,
		footer:true,
		toolbarAdd:true,
		toolbarDelete:true,
		toolbarSave:true
	},
	multiSearch: true,
	markSearchResults: false,	// 詳細検索後のマーク(ヒット箇所色分け)を行わない。詳細検索指定項目以外も色分け表示されるため
	searches: [{}],
	columns: [{}],
	IsEditing: false,
	IsRender:false,
	onToolbar: function(event) {
		var flg = false;
		switch (event.target) {
			case 'reload': flg = true; break;
			case 'add'   : flg = true; break;
			case 'delete': flg = false; break; //キーボードイベント(deleteキー)でonDeleteへ行くので、onDelete内でチェックする必要あり
			case 'edit'  : flg = true; break;
			case 'save'  : flg = true; break;
			default: flg = false;
		}
		if (flg) {
			//セッション確認
			if(!CheckSession(event)) return;

			switch (event.target) {
				case 'reload':								//リロード前確認
					if (this.IsChanged()) {
						event.preventDefault();
						var obj = this;
						w2ext.confirm(msg_ReloadConfirm, function(btn) {
							if (btn === w2ext.buttons.Yes) { obj.reload(); }
						});
					}
					break;

				case 'save':
					event.preventDefault();				// 一旦イベントをキャンセル
					this.DeleteDummyChange();			// ダミー変更データを除去
					if (!this.IsChanged()) {			// 変更が無ければ処理しない
						this.AddDummyChange();			// ダミー変更データ埋め込み
						return;
					}
					var obj = this;
					w2ext.confirm(msg_SaveConfirm, function(btn) {
						if (btn === w2ext.buttons.Yes) {
							obj.save();
						} else {
							obj.AddDummyChange();
						}
					});
					break;

				default:
					if (this.CheckChanged2()) { event.preventDefault(); return; }
			}
		}
	},
	CheckChanged2: function() {
		if (this.IsChanged()) {
			w2ext.alertIcon = w2ext.icons.exclamation;
			w2ext.alert(msg_ChangedAlert);
			return true;
		} else {
			return false;
		}
	},
	onRender: function(event) {
		if(!this.IsRender)
		w2grid_AppendCustomFunctions(this);	 //カスタムファンクションの組み込み
	},
	onLoad: function(event) {
/*		event.onComplete = function () {
			this.AddDummyChange();	  //ダミー変更データ埋め込み
			this.initColumnOnOff();
		};
*/		
	},
	onChange: function(event) {
		// インライン編集で内容を全消去すると、画面には元々の値が表示されるが、内部では変更後内容として空文字""が設定される。
		// なので、変更後内容が空文字のときは、元々の値をセットして画面と一致させる。
		// 但し、手動で元に戻した場合(例:100→1000にした後、再度100を入力する)は、w2ui内でエラーが発生しており、ここまで来ないので対応できない。
		// また、独自拡張<textarea>で設定されている項目は、全消去＆手動復元共にここまで来ない。
		//  独自拡張項目は、
		//  　・全消去した場合、DBも空文字で更新される(必須項目チェックはされていない)
		//	・手動復元した場合、戻す前の入力内容(先の例では,1000)で更新される。
		//
		// 2014/3/7 (仕様統一) 全消去時は全角空白で変更後内容を保持し、必要なタイミングでTrimする
		var recid = event.recid;
		var cName = this.columns[event.column]['field'];
		if (event.value_new === '') {
			  event.value_new = '　'; //event.value_original;
		}
		event.onComplete = function() {
			// 内部の変更後内容(changes配列の要素)をチェックし、元々の値と一緒の場合はchanges配列から該当要素を除去する。
			// 要素除去した結果、changes配列が空になった場合は、changes配列および変更フラグ(changed)を除去する
			var sel = this.get(recid);
			var orgVal = sel[cName];
			var newVal = (sel.changes[cName]) ? sel.changes[cName] : null;
			if (orgVal === newVal) {
				delete sel.changes[cName];
				var cnt = 0;
				for (var key in sel.changes) { cnt++; }
				if (cnt === 0) {
					delete sel['changes'];
					delete sel['changed'];
				}
			}
		};
	},
	onEditField: function(event) {
		// インライン編集で対象となるセルの<inputタグに onblur="w2ui.[自分].IsEditing=false;" を追加設定する
		// <inputタグの生成＆描画はw2ui内部処理に任せ、ここでは、
		// 対象列の編集設定(columns[event.column].editable)のinTagに追加設定を記述する
		// editableにinTagが存在する場合/存在しない場合、inTag定義中に既にonblur=がある場合/無い場合で処理切り分け
		//
		//  inTag無 → inTagに'onblur="w2ui.[自分].IsEditing=false;"'を設定
		//  inTag有(onblur無) → inTagに' onblur="w2ui.[自分].IsEditing=false;"'を追記
		//  inTag有(onblur有) → inTagのonblur="～"の中身を書き換えて、onblur="w2ui.[自分].IsEditing=false;～"にする
		//  ※後で元に戻すため、inTagを編集する前にinTagの内容をbk_inTagに保存しておく
		//
		// (w2ui内部処理で<inputタグの生成と描画が行われる)
		//
		// 画面描画後(event.onComplete)、
		// 　編集モード(IsEditing)をon(true)にする
		// 　ここで追加した設定は、描画後必要なくなるので元のinTagに戻す。
		//
		//
		// 特殊文字対策：
		//  入力された値に特殊文字(&,",>,<)が含まれる場合、w2ui.gridの挙動がおかしくなるので、
		//  フォーカス喪失時(onblur)処理にエンコード処理(w2utils.encodeTags())を組み込む
		//	ESCキーが押された時、w2ui内部処理で編集前の値に戻されるが、ここで組み込むエンコード処理により2重にエンコードされる。
		//	例) 編集前に&amp;で保持していた値が、&amp;amp;になる
		//	これを回避するため、keydownイベント(onkeydown)処理も組み込んで、ここで組み込んだエンコード処理を除去する
		//
		var strCmd_off = 'w2ui.'+this.name+'.IsEditing=false;';
		var strEnc = 'this.value=w2utils.encodeTags(w2utils.stripTags(this.value));';
		var str_Keydown = ' onKeydown="w2ui.'+this.name+'.onFieldKeydown(this, event);"';
		var str_onblur = 'onblur="';
		var re = /onblur="/i;
		var edt = this.columns[event.column].editable;
		if (edt.inTag) {
			edt.bk_inTag = edt.inTag;
			if (String(edt.inTag).match(re)) {
				edt.inTag = String(edt.inTag).replace(re, str_onblur+strCmd_off+strEnc);
			} else {
				edt.inTag += ' '+str_onblur+strCmd_off+strEnc+'"';
			}
		} else {
			edt.inTag = str_onblur+strCmd_off+strEnc+'"';
		}
		edt.inTag += str_Keydown;

		event.onComplete = function() {
			this.IsEditing = true;
			// フォーカス喪失時処理組み込みの後処理
			var edt = this.columns[event.column].editable;
			if (edt.bk_inTag) {
				edt.inTag = edt.bk_inTag;
				delete edt.bk_inTag;
			} else {
				delete edt.inTag;
			}
		};
	},
	// インライン編集時にESCキーが押された場合、encodeTags処理を除去する
	onFieldKeydown: function(obj, event) {
		switch (event.keyCode) {
			case 27: //escape
				var onblur = $(obj).attr("onblur");
				var re = /this\.value=.*;/;
				var newblur = String(onblur).replace(re, '');
				$(obj).attr("onblur", newblur);
				break;
		}
	},
	onClick: function(event) {
		if (this.IsEditing) { event.preventDefault(); return; }
	},
	onDblClick: function(event) {
		if (this.IsEditing) { event.preventDefault(); return; }
	},
	onSearch: function(event) {
		if (this.CheckChanged2()) { event.preventDefault(); return; }
		// スキップ数を0に戻す。※w2grid.skip()の処理(reload以外)をコピー
		var url = (typeof this.url !== 'object' ? this.url : this.url.get);
		if (url) {
			this.offset = 0;
			this.records  = [];
			this.buffered = 0;
			this.last.xhr_offset = 0;
			this.last.pull_more	 = true;
			this.last.scrollTop	 = 0;
			this.last.scrollLeft = 0;
			$('#grid_'+ this.name +'_records').prop('scrollTop',  0);
			this.initColumnOnOff();
		}
	},
	onSort: function(event) {
		if (this.CheckChanged2()) { event.preventDefault(); return; }
	},
	onColumnOnOff: function(event) {
		var obj = this;
		// ツールバーのスキップ数が指定されたとき、
		// ・変更済レコードがある(CheckChanged())とき、イベントキャンセル
		// ・指定された値 > 全レコード数 and 全レコード数 < Limit値 の時、
		//   イベントキャンセルした上で、this.skip(0)する。
		if (event.field === 'skip') {
			if (this.CheckChanged2()) {
				event.preventDefault();
				this.initColumnOnOff();
				setTimeout(function () {
					$().w2overlay();
					obj.toolbar.uncheck('column-on-off');
				}, 100);
				return;
			}
			var val = $(event.checkbox).val();
			if (val > this.total && this.total < this.limit) {
				event.preventDefault();
				this.initColumnOnOff();
				setTimeout(function () {
					$().w2overlay();
					obj.toolbar.uncheck('column-on-off');
				}, 100);
				this.skip(0);
				return;
			}
		}
	},
	onDelete: function(event) {
		if (!event.force) {
			event.preventDefault();
			// インライン編集項目有無確認
			if (this.CheckChanged2()) { return; }
			// 削除確認
			var obj = this;
			var msg = ((obj.getSelection()).length > 100) ? msg_MultiDelConfirm : msg_DeleteConfirm;
			w2ext.confirm(msg, function(btn) {
				if (btn === w2ext.buttons.Yes) {
					//セッション確認
					if(!CheckSession(event)) return;

					// postDataに選択されたレコードの情報をセット.サーバー側でキーを特定するため
					var sel = obj.getSelection();
					var recs = [];
					for (var i=0;i<sel.length;i++) {
						recs[i] = $.extend(true, {}, obj.get(sel[i]));
						for (var key in recs[i]) {
							if ($.inArray(key, obj.RecordKeys) < 0) {
								delete recs[i][key];
							}
						}
					}
					obj.postData = $.extend(true, {}, {'records': recs});

					obj.delete(true);
				}
			});
		}
	},
	onDeleted: function(event) {
		var result = $.parseJSON(event.xhr.responseText);
		this.postData = null;
		if (result.status === result_Done) {
			this.skip(0);			   // 削除後、offset値を0に戻す
			var msg = (result.message) ? result.message : msg_DeleteDone;
			w2ext.alertIcon = w2ext.icons.accept;
			w2ext.alert(msg, msg_TitleDone);
		} else {
			event.preventDefault();
			w2ext.alertIcon = w2ext.icons.error;
			w2ext.alert(result.message, msg_TitleFail);
		}
	},
	onSave: function(event) {
		this.DeleteDummyChange();			   // ダミー変更データを除去
		// postDataに編集されたレコードの情報をセット．サーバ側でキーを特定するため
		var cng = this.getChanges();
		var recs = [];
		for (var i=0;i<cng.length;i++) {
			//recs[i] = $.extend(true, {}, this.get(cng[i].recid));
			recs[i] = GetRowData(this.get(cng[i].recid));
			for (var key in recs[i]) {
				if (key !== 'changes' && $.inArray(key, this.RecordKeys) < 0) {
					delete recs[i][key];
				}
			}
		}
		this.postData = $.extend(true, {}, {'records':recs});
	},
	onSaved: function(event) {
		var result = $.parseJSON(event.xhr.responseText);
		this.postData = null;
		if (result.status === result_Done) {
			this.skip(0);			   // 保存後、offset値を0に戻す
			w2ext.alertIcon = w2ext.icons.accept;
			w2ext.alert(msg_SaveDone, msg_TitleDone);
		} else {
			event.preventDefault();
			this.AddDummyChange();	  //ダミー変更データ埋め込み
			w2ext.alertIcon = w2ext.icons.error;
			w2ext.alert(result.message, msg_TitleFail);
		}
	}
};

// セレクトタグをグリッド内に埋め込む場合に追加する
var gAdditional_function_to_select = {
	// セレクトタグ選択変更時処理
	// サーバ側でselectタグを作成。selectタグ内に
	//  name='lst_xxxxx [レコードNo] [対象フィールドID] [表示フィールドID]'
	//  onchange='w2ui.[グリッド名].onSelectChange(this);'
	// がセットされている事を前提とする
	onSelectChange: function(obj) {
		if (typeof obj.name !== 'string' || typeof obj.value !== 'string') { return; }
		var target = String(obj.name).split(' ');
		if (target.length < 4) { return; }
		var recid = target[1];
		var field = target[2];
		var dispf = target[3];
		if (!$.isNumeric(recid)) { return; }
		var sel = this.get(recid);
		if (typeof sel[field] === 'undefined' || this.columns[dispf] === 'undefined') { return; }
		var rowID = '#grid_'+this.name+'_rec_'+recid+' .w2ui-grid-data';
		var colNo = this.getColumn(dispf,true);

		if (sel[field] === obj.value) {
			if (sel.changes && typeof sel.changes[field] !== 'undefined') {
				delete sel.changes[field];
				var cnt = 0;
				for (var key in sel.changes) { cnt++; }
				if (cnt === 0) {
					delete sel['changes'];
					delete sel['changed'];
				}
				$(rowID).eq(colNo).removeClass('w2ui-changed');
			}
		} else {
			sel.changes[field] = obj.value;
			sel.changed = true;
			$(rowID).eq(colNo).addClass('w2ui-changed');
		}
	}
};

//共通サイドバー
function w2side_AppendCustomFunctions(obj) {
	obj.IsRender=true;
	obj.on('click',function(target, eventData) {
		if(this.nodes[0].id === target) return;
		var n = this.get(target);
		if(n.nodes.length > 0) {
			if(n.expanded) {
				this.collapse(target);
			} else {
				this.expand(target);
			}
		}		
		if(!this.IsLoad)this.selectedID=target;
	});
};

var sCommon = {
	selectedID:'',
	IsLoad:false,
	IsRender:false,
	onRender: function(event) {
		if(!this.IsRender)w2side_AppendCustomFunctions(this);	 //カスタムファンクションの組み込み
	},

	load: function() {
		if(typeof this.url === 'string'){
			this.nodes	= getJSON(this.url,'cmd=get-records&name='+this.name);
		}
	},
	reload: function() {
		if(typeof this.url === 'string'){
			this.IsLoad =true;
			this.remove(this.nodes[0].id);
			this.add(getJSON(this.url,'cmd=get-records&name='+this.name));
			this.select(this.selectedID);
			this.click(this.selectedID);
			this.IsLoad =false;
		}
	},
	nodelist: function(node) {
		var n = (typeof node === 'object') ? node : this.nodes[0].nodes;
		var r = [];
		for (var i = 0; i < n.length; i++) {
			r.push(n[i].text);
			if(n[i].nodes.length>0){
				r = $.merge(r,this.nodelist(n[i].nodes));
			}
		}
		return r;
	},
	getNodepos: function(id,node) {
		var n = (typeof node === 'object') ? node : this.nodes[0].nodes;
		var pos=0;
		for (var i = 0; i < n.length; i++) {
			if(n[i].id === id)return 1;
			if(n[i].nodes.length>0){
				pos = pos + this.getNodepos(id,n[i].nodes);
			}
		}		
		return pos;
	}	
};


//ポップアップ用レイアウト
var lPop = {
	name: 'lPop',
	padding: 4,
	panels: [
		{ type:'main', minSize:300 }
	]
};
//ポップアップ共通部定義
var popCommon = {
	body 	: '<div id="main" style="position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;"></div>',
	modal   : true,
	showMax	: true,
	onClose: function(event) {
		var p = w2ui.lPop;
		for (var i=0; i < p.panels.length; i++) {
			var Pn = p.panels[i].content.name;
			if (w2ui[Pn]) { w2ui[Pn].destroy(); }
		}
		p.destroy();
	},
	onMax : function (event) {
		event.onComplete = function () {
			w2ui.lPop.resize();
		};
	},
	onMin : function (event) {
		event.onComplete = function () {
			w2ui.lPop.resize();
		};
	},
	onKeydown: function(event) {
		switch (event.originalEvent.keyCode) {
			case 27: // esc
				event.preventDefault();
				break;
		}
	}
};
/**
 * Grid表示用のポップアップ設定
 * @param {object} grd w2ui.gridオブジェクト(定義)
 * @param {numeric} h ポップアップの高さ
 * @param {numeric} w ポップアップの幅
 * @returns {undefined}
*/
function setGridPopup (grd, h, w) {
	var winh = (typeof h === 'number') ? h : 700;
	var winw = (typeof w === 'number') ? w : 800;

	if (!w2ui[grd]) {
		$().w2grid(grd);
	}

	openPopup(grd, winh, winw, 'grid');
}
/**
 * Form表示用のポップアップ設定
 * @param {object} frm w2ui.formオブジェクト(定義)
 * @param {numeric} h ポップアップの高さ
 * @param {numeric} w ポップアップの幅
 * @returns {undefined}
*/
function setFormPopup (frm, h, w) {
	var winh = (typeof h === 'number') ? h : 450;
	var winw = (typeof w === 'number') ? w : 500;

	if (!w2ui[frm]) {
		$().w2form(frm);
	}

	openPopup(frm, winh, winw, 'form');
}
/**
 * ポップアップオープン
 * 定義(obj)を受け取り、open時にオブジェクト化、close時に破棄(destroy)する
 * @param {object} obj w2uiオブジェクト(定義)
 * @param {numeric} h ポップアップの高さ
 * @param {numeric} w ポップアップの幅
 * @param {numeric} type オブジェクトの種類
 * @returns {undefined}
*/
function openPopup(obj, winh, winw, type) {
	var popSubCommon = {
		width	: winw,
		height	: winh,
		title:'',
		onOpen: function (event) {
			event.onComplete = function () {
				$('#w2ui-popup #main').w2layout(lPop);
				w2ui.lPop.content('main', w2ui[obj.name]);
			};
		}
	};
	
	switch (type) {
		case 'form':
			
			popSubCommon.title = obj.header;
			popSubCommon.showClose = false;
			popSubCommon.showMax = false;
			w2ui[obj.name].header = '';
//			$().w2popup('open', $.extend(true, {}, popCommon, popSubCommon, popForm));
                        w2popup('open', $.extend(true, {}, popCommon, popSubCommon, popForm));
			break;
		case 'grid':
			var popGrid = { title: obj.header };
//			$().w2popup('open', $.extend(true, {}, popCommon, popSubCommon, popGrid));
                        w2popup('open', $.extend(true, {}, popCommon, popSubCommon, popGrid));
			break;
		default:
//			$().w2popup('open', $.extend(true, {}, popCommon, popSubCommon));
                        w2popup('open', $.extend(true, {}, popCommon, popSubCommon));
			break;
	}
}
/**
 * アラートダイアログ、問い合わせダイアログを表示する。
 *	w2ext.alert(メッセージ[,タイトル][,コールバック関数])
 *
 *		alertを表示する前に、毎回表示アイコンをalertIconに設定する事
 *			w2ext.alertIcon = w2ext.icons.exclamation;		//警告
 *			w2ext.alertIcon = w2ext.icons.error;			//エラー
 *			w2ext.alertIcon = w2ext.icons.accept;			//確認
 *
 *	w2ext.confirm(メッセージ[,タイトル][,コールバック関数])
 *		クリックされたボタンのidがコールバック関数の引数として返される。
 *			w2ext.buttons.Yes	// 'Yes'ボタンが押された場合
 *			w2ext.buttons.No	// 'No'ボタンが押された場合
 *		
 * @type type
 */
var w2ext = {
	btn: '',
	alertIcon: null,
	buttons: {
		Yes	: 'Yes',
		No	: 'No',
		Ok	: 'Ok'
	},
	alert: function(msg, title, callBack) {
		if (typeof callBack === 'undefined' && typeof title === 'function') {
			callBack = title;
			title = w2utils.lang('Notification');
		}
		if (typeof title === 'undefined') {
			title = w2utils.lang('Notification');
		}
		w2ext.btn = '';
		var imgicon = (w2ext.alertIcon) ? w2ext.alertIcon : w2ext.icons.exclamation;
		if ($('#w2ui-popup').length > 0) {
			w2popup.message({
				width	: 400,
				height	: 150,
				html:   '<div style="position: absolute; top: 12px; left: 0px; right: 0px; bottom: 40px; overflow: auto">'+
						'	<div class="w2ui-centered">'+
						'		<div style="font-size:13px;"><img src="'+ imgicon +'" align="middle" style="position:relative;top:-7px;left:-13px;">'+ this.Return2Br(msg) +'</div>'+
						'	</div>'+
						'</div>'+
						'<div style="position: absolute; bottom: 7px; left: 0px; right: 0px; text-align: center; padding: 5px">'+
						'   <input type="button" id="'+ w2ext.buttons.Ok +'" value="OK" onclick="w2popup.message();" class="w2ui-popup-button">'+
						'</div>',
				onOpen: function () {
					var btns = $('#w2ui-popup .w2ui-popup-message .w2ui-popup-button');
					btns.on('click', function () {
						w2popup.message();
					});
					btns.on('blur', function(){
						var bt2 = $('#w2ui-popup .w2ui-popup-message .w2ui-popup-button');
						for (var i=0;i<bt2.length;i++) {
							if (bt2[i].id === w2ext.buttons.Ok) {
								setTimeout(function() {
									$(bt2[i]).focus();
								}, 0);
								break;
							}
						}
					});
					btns.on('keydown', function(event) {
						event.preventDefault();
						switch (event.keyCode) {
							case 13: // enter
								w2popup.message();
								break;
						}
					});
					for (var i=0;i<btns.length;i++) {
						if (btns[i].id === w2ext.buttons.Ok) { $(btns[i]).focus(); break;}
					}
				},
				onClose : function () {
					if (typeof callBack === 'function') { callBack(); }
				}
		});
	} else {
			w2popup.open({
				width	: 450,
				height	: 200,
				showMax	: false,
				modal	: true,
				title	: title,
				speed	: 0.2,
				body:	'<div class="w2ui-centered">'+
						'	<div style="font-size:13px;"><img src="'+ imgicon +'" align="middle" style="position:relative;top:-7px;left:-13px;">'+ this.Return2Br(msg) +'</div>'+
						'</div>',
				buttons:'<input type="button" id="'+ w2ext.buttons.Ok +'" value="OK" class="w2ui-popup-button">',
				onOpen: function (event) {
					event.onComplete = function () {
						var btns = $('#w2ui-popup .w2ui-popup-button');
						btns.on('click', function () {
							w2popup.close();
						});
						btns.on('blur', function(){
							var bt2 = $('#w2ui-popup .w2ui-popup-button');
							for (var i=0;i<bt2.length;i++) {
								if (bt2[i].id === w2ext.buttons.Ok) {
									setTimeout(function(){
									   $(bt2[i]).focus();
									}, 0);
									break;
								}
							}
						});
						btns.on('keydown', function(event) {
							event.preventDefault();
							switch (event.keyCode) {
								case 13: // enter
									w2popup.close();
									break;
							}
						});
						for (var i=0;i<btns.length;i++) {
							if (btns[i].id === w2ext.buttons.Ok) { $(btns[i]).focus(); break;}
						}
					};
				},
				onClose : function (event) {
					event.onComplete = function() {
						if (typeof callBack === 'function') { callBack(); }
					};
				}
			});
		}
	},
	confirm : function (msg, title, callBack) {
		if (typeof callBack === 'undefined' && typeof title === 'function') {
			callBack = title;
			title = w2utils.lang('Confirmation');
		}
		if (typeof title === 'undefined') {
			title = w2utils.lang('Confirmation');
		}
		w2ext.btn = '';
		if ($('#w2ui-popup').length > 0) {
			w2popup.message({
				width	: 400,
				height	: 150,
				html:	'<div style="position:absolute;top:12px;left:0px;right:0px;bottom:40px;overflow:auto;">'+
						'	<div class="w2ui-centered">'+
						'		<div style="font-size:13px;"><img src="'+ w2ext.icons.question +'" align="middle" style="position:relative;top:-7px;left:-13px;">'+ this.Return2Br(msg) +'</div>'+
						'	</div>'+
						'</div>'+
						'<div style="position: absolute; bottom: 7px; left: 0px; right: 0px; text-align: center; padding: 5px">'+
						'   <input id="'+ w2ext.buttons.No +'" type="button" value="'+ w2utils.lang(w2ext.buttons.No) +'" class="w2ui-popup-button">'+
						'   <input id="'+ w2ext.buttons.Yes +'" type="button" value="'+ w2utils.lang(w2ext.buttons.Yes) +'" class="w2ui-popup-button">'+
						'</div>',
				onOpen: function () {
					var btns = $('#w2ui-popup .w2ui-popup-message .w2ui-popup-button');
					btns.on('click', function (event) {
						w2ext.btn = event.target.id;
						w2popup.message();
					});
					btns.on('blur', function(event){
						var bt2 = $('#w2ui-popup .w2ui-popup-message .w2ui-popup-button');
						var next = (event.target.id === w2ext.buttons.Yes) ? w2ext.buttons.No : w2ext.buttons.Yes;
						for (var i=0;i<bt2.length;i++) {
							if (bt2[i].id === next) { $(bt2[i]).focus(); event.preventDefault(); break;}
						}
					});
					btns.on('keydown', function(event) {
						event.preventDefault();
						switch (event.keyCode) {
							case 9: // tab
								$(event.target).blur();
								break;
							case 13: // enter
								$(event.target).click();
								break;
						}
					});
					for (var i=0;i<btns.length;i++) {
						if (btns[i].id === w2ext.buttons.Yes) { $(btns[i]).focus(); break;}
					}
				},
				onClose: function() {
					if (typeof callBack === 'function') { callBack(w2ext.btn); }
					w2ext.btn = '';
				}
			});
		} else {
			w2popup.open({
				width		: 450,
				height		: 200,
				title		: title,
				modal		: true,
				showClose	: false,
				speed		: 0.2,
				body:		'<div class="w2ui-centered">'+
							'	<div style="font-size:13px;"><img src="'+ w2ext.icons.question +'" align="middle" style="position:relative;top:-7px;left:-13px;">'+ this.Return2Br(msg) +'</div>'+
							'</div>',
				buttons:	'<input id="'+ w2ext.buttons.No +'" type="button" value="'+ w2utils.lang(w2ext.buttons.No) +'" class="w2ui-popup-button">'+
							'<input id="'+ w2ext.buttons.Yes +'" type="button" value="'+ w2utils.lang(w2ext.buttons.Yes) +'" class="w2ui-popup-button">',
				onOpen: function (event) {
					event.onComplete = function () {
						var btns = $('#w2ui-popup .w2ui-popup-button');
						btns.on('click', function (event) {
							w2ext.btn = event.target.id;
							w2popup.close();
						});
						btns.on('blur', function(event){
							var bt2 = $('#w2ui-popup .w2ui-popup-button');
							var next = (event.target.id === w2ext.buttons.Yes) ? w2ext.buttons.No : w2ext.buttons.Yes;
							for (var i=0;i<bt2.length;i++) {
								if (bt2[i].id === next) { $(bt2[i]).focus(); break;}
							}
						});
						btns.on('keydown', function(event) {
							event.preventDefault();
							switch (event.keyCode) {
								case 9: // tab
									$(event.target).blur();
									break;
								case 13: // enter
									$(event.target).click();
									break;
							}
						});
						for (var i=0;i<btns.length;i++) {
							if (btns[i].id === w2ext.buttons.Yes) { $(btns[i]).focus(); break;}
						}
					};
				},
				onClose: function(event) {
					event.onComplete = function() {
						if (typeof callBack === 'function') { callBack(w2ext.btn); }
						w2ext.btn = '';
					};
				}
			});
		}
	},
	Return2Br: function(html) {
		if (html === null) return html;
		switch (typeof html) {
			case 'number':
					break;
			case 'string':
					html = String(html).replace(/\n/g, "<br>");
					break;
			case 'object':
					for (var a in html) html[a] = this.Return2Br(html[a]);
					break;
		}
		return html;
	},
	icons: {
//  icons obtained from http://ec-sozai.net/
		accept: 'data:image/png;base64,'+
			'iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz'+
			'AAALEgAACxIB0t1+/AAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAABZ0RVh0'+
			'Q3JlYXRpb24gVGltZQAwMy8xNC8xMfMrQs0AAAO5SURBVEiJrZZdaFtlGMd/OUlOPtY2SQ1t1YqV'+
			'Zlvb1A5dQK0TYd4NsTVFBl6sjImFYUEUBWErYi9UJgpWyxRlIILI6FanF96osM2wyWgvuiw1plPo'+
			'apd+nX6ZtDntOV4cc3pOzpI26v8qz5PnPb/3Pe973udvm52dZRudBN7argjoA/pLFdhKwKLA0A4g'+
			'heoCzpUDU43Br3PXGEvH+GMxzmpuESk7Q8BTQ4Xop8Ef5sHadvYGI5Zn7wSmg5LzowwnBpnJpHA6'+
			'wWEHwQaCAIoCigobmyDLUOMN0dl8nD13PVQUWAhTARRVYTgxSOzWEC4RROedFm9WTob1HLTXd9HZ'+
			'fBzBJliARpgOOjP6JsmFS3g920MKlclCKNDOsYf7LcB8FM1nL4yf/tcgAK8HUlKMC+OnjemoETYE'+
			'2h5dnjyLx10+5J6q3TzT8jIAHjdcnjxLcn40//eQEQbAcGIQlwg2yzkqrUj9IV5/8msqxACgjXeJ'+
			'2vOMEvhnr25KY6QzqR0dBqMeuz9K9/53sQtOMvKSnhedkM6kuCmN5VOqvrLr6RiiozzQA9X7ONx2'+
			'Qo/tgnmmogPiM1f0WIcl50dwlAHzij6ORk6ZAPf5Wkw1TgckZn+xwpbW5hBMO1ha3fvfIeC5W4+z'+
			'8iojU9+bagQBpGzaCvtLXka4w8GwC06eCh3FK/r0XKT+EC01B/T49soEb/8U5eLvX5nG2myQkVf0'+
			'WH9xu5xVKOqCCbgn+AjPtb1BXWUjla4Aw/H3sQtOOsKv6jV/Lv/GQOwYq+uSZaKqCh7HLuvKfO4g'+
			'irJV2Bl+hd7HP6OushGAAw2HqXIFOdh4BL+7ZlsQaPdntXfrVeuwUPU+Nja2Cr9NDHD++ik2FRkA'+
			'l8PL0829HGzsBmB1XeLTq71FQQDyBjQZuoEOa6t7gpwBtqnI/DjxBe9dfB4pOw1o31SFK6Ddn9de'+
			'Yz4zVRQEkNuA1tp2E6wVoMEfptYbIiebB9xaGueDS93cXpnQc98lPiQ5d7U0SIZab4gGfzifahWA'+
			'OIBgE+ho6mE9Zx0oZaf5OPYiUnaaycUb/JA6UxIEWrvpaOox3vzx/K8+gL3BCO31XWSy1sGLazMM'+
			'/PwCX46eQFEVa4FBmazW1wzduw+K9LPPR06SkmL/ez8r2qnP3fiIK1Pny+7Uj977LNGWl7bt1CYg'+
			'aEbnm/FPzB5E0HyIomrfkdGDdDT1FBqfkh7EAsxD8+5qaW2O5fUFqlzV+NzB/+yu8tqpOS1UUbNa'+
			'6p7vR5tdXxkQWzEQwN8kyHfwFX3KEgAAAABJRU5ErkJggg==',
		exclamation: 'data:image/png;base64,'+
			'iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz'+
			'AAALEgAACxIB0t1+/AAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAABZ0RVh0'+
			'Q3JlYXRpb24gVGltZQAwMy8xNC8xMfMrQs0AAAKoSURBVEiJtZbPS1RRFMc/576ZRrOBCAYzDAyk'+
			'hdhChSAQXEj+AfoHqC0DN22kIBcKhv+Au378A7ZqEYiQIbpxbJNuDNyYvwZK0GmcZt49LV7vze83'+
			'b4i+q7nnXu7nnDnn3XMkk8nQRC+B+WaHgDlgIeyAhMDGgZUIkGpNAO9bgWnFoeMNOFxDMl8g/wOy'+
			'R9BxBxK30NQAdI+iXcM1d0eBBSA52ULSi8jFHiZukZiCgBhFrYCCFgVbMGiyDx16gd5+1BBYDfNA'+
			'6iLpV5hvbzEJi4nbetFXyBYMNm+wvdPo0HMQpwZYDiuBPs/gnH3EaXebQqrl5hzc1GN0ZLkGaP4u'+
			'xgPrzlJD0LUHz0hOZUlOZbk+9qEuzGl3cTKryM5SuXm8HLYCXo7M/muctuYR6e+fDfecNhez/xo5'+
			'2fJNK+UwL6r0IiZh69RRPdh5400Bk7BIerHCbPBzdbYdVF0U2YuD0H0Tt8jFHpxtB/4FkcnhWmRQ'+
			'VJmYRb5/Kq0D2MmW9x1FlOZD/kb/zrgiR+u1MHKniITDTPJeZGfA+/jJHteB5c+ryiVc9jI8Zx4N'+
			'KCukWPArcRPsr1Dg1eYMV5sz0T1SIJ4MlqWr2ztRjVDzLUitwI3uWph2PkSL4bCOia/BCxK//6Q5'+
			'rCgV3aAEuzuGLbSQtAiyBYN2j1bA+gFIDaDJvsjAZgXitx1SA76p3wC7AIiDDs5i841hrZS+zRt0'+
			'cLb85d/1q3EOmNeuYWzvNO7Bm7qv/sW7jkggN+d4fa2Urzlo1M/Wn+JkVv9bPwsMiIOOLOP2TFK8'+
			'jEXPYcFQvIzh9kzWBVVH5qs0gxxvIDtLFTOIiHouWlCVyhlkcLZ68AmdQWqAPjSYrnKnkMtAe8p7'+
			'CP5xuvIVdTitVsNhNSwhC3jezbUAkUYggD/OJSPPzlV+/wAAAABJRU5ErkJggg==',
		error: 'data:image/png;base64,'+
			'iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz'+
			'AAALEgAACxIB0t1+/AAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAABZ0RVh0'+
			'Q3JlYXRpb24gVGltZQAwMy8xNC8xMfMrQs0AAAOzSURBVEiJpZZPTBxVHMc/7w3LLruLTaPdbsXY'+
			'NlE8aPQgSGtigNI0Nr0YTCVkE26NaYxR0R7lYI8C0igxjYfGEDSaYLySSGAltl2QUo0X0It/SmFG'+
			'00JZlmWYeR7orPP2sRTi9/Z+8+b3eb8333nvJxzH4QF6H/jgQZOAHuDiThPEDrB2YGQXkHK9Cnyz'+
			'F5gKD25dv8bv2XHsn39i/c4dVhdvk0wfIrZ/P6lnn+Nwcyt1x44buXcDK4EWpnPk+nu5Nz9HVAoi'+
			'QiAQWAI8BQqFqxRFX1Fb/xRN3e/xaGNTRWA5TAEo3yfX/yHzXw5TIyVRaSzSUNFXFHyf+s4MTd0X'+
			'EFIawDCsBBq70M1SdpykJc292EEKWPV8Ui81c7JvwAAGo/YgOjXQx1J2nNo9goKMtZbEnswyNdAX'+
			'ftQeho3A1jeaGx4iaUk9iWURiSe2BVixGMKytFjSkswND7EwnQtCI2EYALn+XmqkXpGwLFovDXLq'+
			'ypABtGIxXv78C1ovDWpAAdRISa6/V5svuf+tFm/eYOW+68pBR06f4WBDowYMQAcbGjly+owBjErB'+
			'yvwcizdvBCFVquyP7IThuqpojHg6XRoHwJoDB0qgQPF0mqpoTHs/KgV/Tn6vVQbAwlSOaqHD3LU8'+
			'o10Z7NkZDfjaxFUNZM/OMNqVwV3La+9XC8FfV38wYXnbRgrTfwFw6cfpUsyK/VdBJRCAFILVxdsm'+
			'rLiyXNHq7lqesfPn8NbXtbi3vs7Y+XPbgoLkxeVlExZ9aJ9+IIZkxWK0ffqZVlEQP/HJ5Yq/hQKq'+
			'k0kTlkil8JWJC7suXFGgcpeG5SlFbd1jJuzQ8w1slMEi8YQBsmdn+LrlRcM02wE3lNJugxLs8Ik2'+
			'ir4O89wNCo6tgUa7MhQcx3BpwbHx3A3t/aKveLy5pTQWjuM8DfyifJ9vMx1s/var9r/JSISWjz4m'+
			'nk4brovEE5y6MkTBsZl4501819VAVU88ySvDXwUH8jPBqa9g65Ice+N19lVZmjNlJIIVqd7WdZF4'+
			'As/d0EAKWN70aBu8HN5GEWxjD0DdsePUd2ZY9Xwtoe+6Fe3truU1EGxdM/WdmTCoJ9jG8IJQvs93'+
			'776NPZmltuz0343u7eI+KwWElJzsG+Do2Q7ubnqGaSqp6CvubnocPduxLai8skCl7LeuX2PqUr/W'+
			'g0ghkIAP+ErvQV54q7u88dmxBzGAATTorvK2TeGfv6l5+BESqdT/7q4C7bY5LVfFZnUnB1xka3U9'+
			'e4CISiCAfwHJg65g4mpiKQAAAABJRU5ErkJggg==',
		question: 'data:image/png;base64,'+
			'iVBORw0KGgoAAAANSUhEUgAAABsAAAAbCAYAAACN1PRVAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz'+
			'AAALEgAACxIB0t1+/AAAABh0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzT7MfTgAAABZ0RVh0'+
			'Q3JlYXRpb24gVGltZQAwMy8xNC8xMfMrQs0AAANCSURBVEiJrZbNbxNHGIefmXXiOHEajIMtFKIC'+
			'iapUQZhU4kIrLhE5V66qtJXyB3DoDbg1quDWcqv6FyARQCLihgTlAmouPSQrFIGiElRFbonzYYId'+
			'25tkZ3pwd+3x+iuF32n21cw+85uv9xUbGxu00Q/A9XadgFngRqsOogUsDdzvAFKvr4D5w8B07cfy'+
			'epnFTJE/txzyjmKreEC8N0R/WDIaDzMx1Mt4sifw705gPuhFtszcUo61d/tIIRBSAAIhQOtKV600'+
			'SmuGP+ri23MxPk0YUANYD9MASsOdpW0evyogpUTKwCQDUkqjlOLSSJRvzh2lZojfqoX5oF8XNlh8'+
			'U8ayZFtIvVxXkUqG+f7zRADo/S3tRe/Zuf8NArAsib3ucM/O1YbTUHWmobJHPz3NEgpZgZ+MDEZI'+
			'pxJcOHXEj9mZPI9ebrPw+m2g/8GBy7WLido9FMb055ZySBl0NDIY4eaXnxgggNRQP1cnP2ZqLB4Y'+
			'I6VkbilnxjxXK5sOazv7DQ/D1cmTfrvguNz64x/sTN6PzZw/TjRsroaUgrWdfVY2HS+kfRuLmWJD'+
			'ULK/m2R/t/995cEK83aWHx+usp7fAyAatujrDi69lAL775L/HfIaL7Ll/+6Rqd29ihPPlQeYGosb'+
			'k9jdcwNjhRQ8f1Pi67NHTFiu5CKCl56C4zJvZ43Y5S9OGPu08PotBacBTAi2igdVp9WZqQYPTFDp'+
			'VMIA2Zk8Pz/5q2n/3T3lt31nfd2SoktbYO2JnLez/hI3U6Srerr9Vixioc33t6G8U/dqs9QWpLXm'+
			'WJ/vp+ps7FgPa+8KCKu1tUcvtwAa7lEAprSRDXxnn53oRan2zqbG4sycP86FUwNt+yqlmRjqNWBn'+
			'AEbjYYYHujoCdiKlNMMDXYzGw17oTAhYBpACplMxbj7LImXwgnrqdBmVUkynBmtf/mVvz2aB6+PJ'+
			'Hi6NRPltdbfpq19/5xrJdSt5rWa/ZqFJPvvl9yz2uvPB81nTTH17cZsnq4fP1JOno3w30T5TG0Co'+
			'FDp3bbMGEYjKcA26rgaZTsXqC5+WNUgA6EG96ipXctkpuwz0WMQi1ntXV546LU7r1bRYbXUCblCZ'+
			'3ewhIKIZCOBfhDxozvp/VHsAAAAASUVORK5CYII='
	}
};

var RootPath	= '../';
$(document).ready(function () {
	//Window幅の取得と設定
	var wheight=$(window).height()-15;
	$("#layout").css("height",wheight);
	//表示言語の設定
	w2utils.locale( RootPath+'locale/ja-jp.json');
});
	
/**
 * Windowリサイズに連動してレイアウトもリサイズ
 */
$(window).resize(function() {
	var wheight=$(window).height()-15;
	$("#layout").css("height",wheight);
});

/**
 * backspaceキーを無効にする
 * ページが戻るのを抑止。
 * http://www.vilepickle.com/blog/2010/11/18/0090-disabling-backspace-key-page-jquery#.UyFDsYXm5AE
 */
$(document).keydown(function(e) {
	var element = e.target.nodeName.toLowerCase();
	if (element !== 'input' && element !== 'textarea') {
		if (e.keyCode === 8) {
			return false;
		}
	}
});
