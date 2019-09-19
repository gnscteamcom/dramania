__.d('MonitoringReportImportFile',['$','vsprintf','escape','csrf','ajax','jsonParse','uriAjax','apiErrorResponse','Event'],function($, vsprintf, escape, csrf, ajax, jsonParse, uriAjax, apiErrorResponse, Event){
/**
 */
var File = this.exports = function($target, options){
	this.$target = $($target);
	this.options = options;
	this._init();
};
File.prototype = {
	_init:function(){
		this.event = new Event();
		this._head = new FileHead(this);
		this._list = new FileList(this);
	},
	show:function(){
		this._load||this.load();
		this.$target.show();
	},
	hide:function(){
		this.$target.hide();
	},
	load:function(){
		this._load = true;
		this._list.load();
	},
	reload:function(){
		this._list.reload();
	},
	on:function(type, callback){
		this.event.on(type, callback);
	},
	off:function(type, callback){
		this.event.off(type, callback);
	}
};

/**
 */
var FileHead = function(file){
	this.file = file;
	this._init();
};
FileHead.prototype = {
	_uploadListItemLoading:
		'<table class="loading">' +
			'<tbody>' +
				'<tr>' +
					'<td class="icon">' +
						'<i class="icon-cloud-upload"></i>' +
					'</td>' +
					'<td class="detail">' +
						'<div class="name">%s</div>' +
						'<div class="status">' +
							'File upload <span class="progress">0%</span>' +
						'</div>' +
					'</td>' +
					'<td class="action">' +
						'<i class="icon-close"></i>' +
					'</td>' +
				'</tr>' +
			'</tbody>' +
		'</table>',
	_uploadListItemSuccess:
		'<table class="success">' +
			'<tbody>' +
				'<tr>' +
					'<td class="icon">' +
						'<i class="icon-check"></i>' +
					'</td>' +
					'<td class="detail">' +
						'<div class="name">%s</div>' +
						'<div class="status">' +
							'File upload success.' +
						'</div>' +
					'</td>' +
					'<td class="action">' +
						'<i class="icon-close"></i>' +
					'</td>' +
				'</tr>' +
			'</tbody>' +
		'</table>',
	_uploadListItemError:
		'<table class="error">' +
			'<tbody>' +
				'<tr>' +
					'<td class="icon">' +
						'<i class="icon-ghost"></i>' +
					'</td>' +
					'<td class="detail">' +
						'<div class="name">%s</div>' +
						'<div class="status"></div>' +
					'</td>' +
					'<td class="action">' +
						'<i class="icon-close"></i>' +
					'</td>' +
				'</tr>' +
			'</tbody>' +
		'</table>',
	_init:function(){
		this.$target = this.file.$target.find("#head");
		this._initClose();
		this._initUpload();
	},
	_initClose:function(){
		this.$close = this.$target.find("#close");
		this.$close.click(this.file.hide.bind(this.file));
	},
	_initUpload:function(){
		this.$upload = this.$target.find("#upload");
		this.$uploadInput = this.$upload.find("#input");
		this.$uploadRecord = this.$upload.find("#record");
		this.$uploadInput.find('.control').fileupload({
			url: uriAjax('admin/monitoringReportImportFileUpload'),
			dataType: 'json',
			global: false,
			autoUpload: false,
			maxFileSize: 1024 * 1000 * 4 /* 4MB */,
			converters: {'text json': jsonParse},
			headers: csrf()
		})
		.on('fileuploadadd',this._onfileuploadadd.bind(this))
		.on('fileuploadprocessalways',this._onfileuploadprocessalways.bind(this))
		.on('fileuploadprogress',this._onfileuploadprogress.bind(this))
		.on('fileuploaddone',this._onfileuploaddone.bind(this))
		.on('fileuploadfail',this._onfileuploadfail.bind(this));
	},
	_onfileuploadadd:function(e, data){
		var file = data.file = data.files[0],
			$target = data.$target = $('<div class="item"></div>'),
			$content = data.$content = $(vsprintf(this._uploadListItemLoading,[escape(file.name)]));
		$content.find('.action').click(function(){
			data.$content = null;
			$content.remove();
			data.abort();
		});
		$target.html('').append($content);
		this.$uploadRecord.prepend($target);
	},
	_onfileuploadprocessalways:function(e, data){
		if (data.file.error) {
			this._onfileuploadfail(e, data);
			return;	
		}
		var timeout = setTimeout(function(){
			clearTimeout(timeout);
			data.submit();
		},100);
	},
	_onfileuploadprogress:function(e, data){
		var $content = data.$content,
			progress = parseInt(data.loaded / data.total * 100, 10);
		$content.find('.progress').html(progress + '%');
	},
	_onfileuploaddone:function(e, data){
		var file = data.file,
			$content = data.$content = $(vsprintf(this._uploadListItemSuccess,[escape(file.name)]));
		$content.find('.action').click(function(){
			data.$target.remove();
			data.$content = null;
			data.$target = null;
		});
		this.file.reload();
		data.$target.html('').append($content);
	},
	_onfileuploadfail:function(e, data){
		var file = data.file,
			error = apiErrorResponse(data.jqXHR,{message:file.error||'File upload error.'}),
			$content = data.$content = $(vsprintf(this._uploadListItemError,[escape(file.name)]));
		$content.find('.status').html(error.message);
		$content.find('.action').click(function(){
			data.$target.remove();
			data.$content = null;
			data.$target = null;
		});
		data.$target.html('').append($content);
	},
};

/**
 */
var FileList = function(file){
	this.file = file;
	this._init();
};
FileList.prototype = {
	_init:function(){
		this.$target = this.file.$target.find("#list");
		this._record = new FileListRecord(this);
		this._action = new FileListAction(this);
	},
	load:function(){
		this._record.load();
	},
	reload:function(){
		this._record.reload();
	}
};

/**
 */
var FileListRecord = function(list){
	this.list = list;
	this._items = [];
	this._take = 20;
	this._page = 0; 
	this._init();
};
FileListRecord.prototype = {
	_init:function(){
		this.$target = this.list.$target.find("#record > .row");
	},
	load:function(){
		if (this._page > 0) throw new Error();
		var self = this,
			data = {page:this._page};
		ajax('admin/monitoringReportImportFile',{
			data: data,
			beforeSend:function(){
				self.list._action.hideRetry();
				self.list._action.hideContinue();
				self.list._action.showLoading();
			},
			success:function(files){
				self.list._action.hideLoading();
				if (files.length > 0) {
					if (files.length >= self._take) self.list._action.showContinue(self.more.bind(self));
					self.setItems(files);
					self._page++;
				} else {
					self.list._action.showEmpty();
				}
			},
			error:function(){
				self.list._action.hideLoading();
				self.list._action.showRetry(self.load.bind(self));
			}
		});
	},
	more:function(){
		if (this._page == 0) throw new Error();
		var self = this,
			data = {page:this._page};
		ajax('monitoring/reportImportFile',{
			data: data,
			beforeSend:function(){
				self.list._action.hideRetry();
				self.list._action.hideContinue();
				self.list._action.showLoading();
			},
			success:function(files){
				self.list._action.hideLoading();
				if (files.length > 0) {
					if (files.length >= self._take) self.list._action.showContinue(self.more.bind(self));
					self.addItems(files);
					self._page++;
				}
			},
			error:function(){
				self.list._action.hideLoading();
				self.list._action.showRetry(self.more.bind(self));
			}
		});
	},
	reload:function(){
		this._page = 0;
		this._items = [];
		this.$target.html('');
		this.list._action.hideEmpty();
		this.load();
	},
	addItem:function(file){
		var item = new FileListRecordItem(this, file);
		this.$target.append(item.render());
		this._items.push(item);
	},
	addItems:function(files){
		files.forEach(this.addItem.bind(this));
	},
	setItems:function(files){
		this._items = [];
		this.$target.html('');
		files.forEach(this.addItem.bind(this));
	},
	getItems:function(){
		return this._items;	
	}
};

/**
 */
var FileListRecordItem = function(record, file){
	this.record = record;
	this.file = file; 
};
FileListRecordItem.prototype = {
	_html:
		'<div class="item col-md-2 col-normal" title="%s">' +
			'<div class="panel">' +
				'<div class="panel-body">' +
					'<div class="icon">' +
						'<i class="icon-doc"></i>' +
					'</div>' +
					'<div class="loading">' +
						'<table>' +
							'<tbody>' +
								'<tr>' +
									'<td align="center">' +
										'<div class="la-ball-clip-rotate la-28"><div></div></div>' +
									'</td>' +
								'</tr>' +
							'</tbody>' +
						'</table>' +
					'</div>' +
				'</div>' +
				'<div class="panel-footer">' +
					'<table>'+
						'<tbody>'+
							'<tr>'+
								'<td class="detail">'+
									'<div class="name">%s</div>' +
									'<div class="date">%s</div>' +
								'</td>'+
								'<td class="action">'+
									'<div class="dropdown dropup">' +
										'<div class="dropdown-toggle" data-toggle="dropdown">' +
											'<i class="icon-settings"></i>' +
										'</div>' +
										'<ul class="dropdown-menu dropdown-menu-right">' +
											'<li class="remove"><a href="javascript:;">Hapus</a></li>' +
										'</ul>' +
									'</div>' +
								'</td>' +
							'</tr>'+
						'</tbody>'+
					'</table>' +
				'</div>' +
			'</div>' +
		'</div>',
	render:function(){
		if (this.$html) return this.$html;
		this.$html = $(vsprintf(this._html,[
			escape(this.file.name),
			escape(this.file.name),
			escape(this.file.datetime)
		]));
		this.$loading = this.$html.find('.loading');
		this.$html.find('.panel-body').click(this.select.bind(this));
		this.$html.find('.remove').click(this.remove.bind(this));
		return this.$html;
	},
	select:function(){
		this.record.list.file.event.apply('select',[this.file]);
	},
	remove:function(){
		if (this._loading) return;
		var self = this,
			data = {uid:this.file.uid};
		ajax('admin/monitoringReportImportFileRemove',{
			data: data,
			method: 'post',
			beforeSend:function(){
				self._loading = true;
				self.$loading.show();
			},
			success:function(response){
				self._loading = false;
				self.record.list.reload();
			},
			error:function(){
				self._loading = false;
				self.$loading.hide();
			}
		});
	}
};

/**
 */
var FileListAction = function(list){
	this.list = list;
	this._init();
};
FileListAction.prototype = {
	_init: function(){
		this.$target = this.list.$target.find("#action");
		this.$empty = this.$target.find("#empty");
		this.$loading = this.$target.find("#loading");
		this.$retry = this.$target.find("#retry");
		this.$continue = this.$target.find("#continue");
	},
	showEmpty:function(){
		this.$empty.show();
	},
	hideEmpty:function(){
		this.$empty.hide();
	},
	showLoading:function(){
		this.$loading.show();
	},
	hideLoading:function(){
		this.$loading.hide();
	},
	showRetry:function(callback){
		this.$retry.off('click').on('click',callback).show();
	},
	hideRetry:function(){
		this.$retry.off('click').hide();
	},
	showContinue:function(callback){
		this.$continue.off('click').on('click',callback).show();
	},
	hideContinue:function(){
		this.$continue.off('click').hide();
	}
};

});