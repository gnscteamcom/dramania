__.d('page_monitoring_report_import',['$','MonitoringReportImportFile', 'MonitoringReportImportFileInput'],function($, MonitoringReportImportFile, MonitoringReportImportFileInput){
/**
 */
var _ = this.exports = {
	init:function($target, options){
		if (_.page) throw new Error();
		this.page = new Page($target, options);
		return this.page;
	},
	ready:function($target, options, callback){
		callback = callback||$.noop;
		$(document).ready(function(){
			callback(_.init($target, options));
		});
	}
};

/**
 */
var Page = function($target, options){
	this.$target = $($target);
	this.options = options;
	this._init();
};
Page.prototype = {
	_init:function(){
		this._monitoringReportImportFile = new MonitoringReportImportFile(this.$target.find("#monitoring_report_import_file"));
		this._monitoringReportImportFileInput = new MonitoringReportImportFileInput(this.$target.find("#monitoring_report_import_file_input"),{
			file: this._monitoringReportImportFile
		});
	}
};

});