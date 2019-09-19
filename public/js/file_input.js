__.d('MonitoringReportImportFileInput',['$','vsprintf'],function($, vsprintf){
/**
 */
var Input = this.exports = function(target, options){
	this.$target = $(target);
	this.options = options;
	this._init();
};
Input.prototype = {
	_init:function(){
		this.$show = this.$target.find("#show");
		this.$clear = this.$target.find("#clear");
		this.$valueUid = this.$target.find("#value-uid");
		this.$valueName = this.$target.find("#value-name");
		this.$show.click(this.show.bind(this));
		this.$clear.click(this.clear.bind(this));
		this.$valueName.click(this.show.bind(this));
		this.options.file.on('select', this.select.bind(this));
	},
	show:function(){
		this.options.file.show();
	},
	hide:function(){
		this.options.file.hide();
	},
	clear:function(){
		this.setval({});
	},
	setval:function(file){
		this.file = file;
		this.$valueUid.val(file.uid||'');
		this.$valueName.val(file.name||'');
	},
	select:function(file){
		this.setval(file);
		this.hide();
	}
};

});