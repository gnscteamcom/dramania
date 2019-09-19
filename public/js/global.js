/**
 */
__.d('$',[],function(){
	this.exports = window.jQuery;
});

/**
 */
__.d('uri',['config'],function(config){
	var uri = {
		host: config[0][0],
		path: config[0][1],
		base: config[0][1] + '/'
	};
	this.exports = function(key){
		return key == null ? $.extend({},uri) : uri[key];
	};
});

/**
 */
__.d('csrf',['config'],function(config){
	var csrf = {
		'X-Csrf-Token': config[1][0]
	};
	this.exports = function(key){
		return key == null ? $.extend({},csrf) : csrf[key];
	};
});

/**
 */
__.d('uriBase',['$','uri'],function($, uri){
	this.exports = function(path, params){
		var result = uri('base');
		if (path != null) {
			result += Array.isArray(path) ? path.join('/') : path;
		}
		if (params != null) {
			result += '?' + $.param(params);
		}
		return result;	
	};
});

/**
 */
__.d('uriAjax',['$','uriBase'],function($, uriBase){
	this.exports = function(path, params){
		path = path||'';
		path = Array.isArray(path) ? path.join('/') : path;
		return uriBase(['ajax', path], params);
	};
});

/**
 */
__.d('jsonWrap',[],function(){
	var prefix = ")}]'\n",
		length = prefix.length;
	this.exports = function(context){
		if (context.substr(0, length) === prefix) {
			context = context.substr(length);
		}
		return context;
	};
});

/**
 */
__.d('jsonParse',['$','jsonWrap'],function($, jsonWrap){
	var parent = $.parseJSON;
	this.exports = function(context){
		return parent(jsonWrap(context));
	};
});

/**
 */
__.d('xhr',['$','csrf','jsonParse'],function($, csrf, jsonParse){
	var parent = $.ajax;
	var params = {
		data: {},
		global: false,
		dataType: 'json',
		converters: {'text json': jsonParse},
		headers: csrf()
	};
	this.exports = function(options){
		options = $.extend({}, params, options);
		return parent(options);
	};
});

/**
 */
__.d('ajax',['$','xhr','uriAjax'],function($, xhr, uriAjax){
	this.exports = function(path, options){
		return xhr($.extend(options,{
			url: uriAjax(path)
		}));
	};
});

/**
 */
__.d('apiResponse',[],function(){
	this.exports = function(response, value){
		return response && response.responseJSON ? response.responseJSON : value;
	};
});

/**
 */
__.d('apiErrorResponse',['apiResponse'],function(apiResponse){
	this.exports = function(response, value){
		return apiResponse(response,{}).error || value;
	};
});

/**
 */
__.d('apiParamErrorResponse',['apiResponse'],function(apiResponse){
	this.exports = function(response, value){
		return apiResponse(response,{}).param || value;
	};
});

/**
 */
__.d('apiParamsErrorResponse',['apiResponse'],function(apiResponse){
	this.exports = function(response, value){
		return apiResponse(response,{}).params || value;
	};
});

/**
 */
__.d('apiStatusErrorResponse',['apiResponse'],function(apiResponse){
	this.exports = function(response, value){
		return apiResponse(response,{}).status || value;
	};
});

/**
 */
__.d('vsprintf',[],function(){
	this.exports = function(text, params){
		var index = 0;
		return String(text).replace(/(%s)/g,function(b, v){
			if (params[index] != null)v = params[index++];
			return v;
		});
	};
});

/**
 */
__.d('sprintf',['vsprintf'],function(vsprintf){
	this.exports = function(text){
		return vsprintf(String(text), Array.prototype.slice.call(arguments, 1));
	};
});

/**
 */
__.d('escape',[],function(){
	var escapeMap = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#x27;',
		'`': '&#x60;'
	};
	var escapeRegExp = /(?:&|<|>|"|'|`)/g;
	this.exports = function(text){
		return String(text).replace(escapeRegExp,function(v){
			return escapeMap[v];
		});
	};
});

/**
 */
__.d('unescape',[],function(){
	var unescapeMap = {
		'&amp;' : '&',
		'&lt;'  : '<',
		'&gt;'  : '>',
		'&quot;': '"',
		'&#x27;': "'",
		'&#x60;': '`'
	};
	var unescapeRegExp = /(?:&amp;|&lt;|&gt;|&quot;|&#x27;|&#x60;)/g;
	this.exports = function(text){
		return String(text).replace(unescapeRegExp,function(v){
			return unescapeMap[v];
		});
	};
});

/**
 */
__.d('num_random',[],function(){
	var chars = "0123456789";
	this.exports = function(length){
		var text = "";
		for (var i = 0; i < length; ++i) {
			text += chars.charAt(Math.floor(Math.random() * chars.length));
		}
		return text;
	};
});

/**
 */
__.d('str_random',[],function(){
	var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	this.exports = function(length){
		var text = "";
		for (var i = 0; i < length; ++i) {
			text += chars.charAt(Math.floor(Math.random() * chars.length));
		}
		return text;
	};
});