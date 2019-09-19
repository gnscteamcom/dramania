/*!
 * @author Yudha Tama Aditiyara <yudhatamaaditiyara@gmail.com>
 * Licensed under the MIT license
 */
window.__||(function(__){

/**
 */
var nonamed = 0;
var modules = {};
var waiting = {};
var timeout = 10;

/**
 */
var Module = function(name, dependencies, callback, flag){
	if (Object.prototype.toString.call(name) !== '[object String]') {
	    flag = callback;
		callback = dependencies;
		dependencies = name;
		name = 'module#' + nonamed++;
	}
    if (Object.prototype.toString.call(dependencies) !== '[object Array]') {
		flag = callback;
		callback = dependencies;
		dependencies = new Array();
	}
	this.name = name;
	this.dependencies = dependencies;
	this.callback = callback;
	this.flag = flag >> 0 || Module.FLAG_PENDING;
	this.exports = null;
	this.counter = 0;
};

/**
 */
Module.FLAG_EXECUTE = 1;
Module.FLAG_PENDING = 2;

/**
 */
Module.prototype = {
	/**
	 */
	constructor: Module,

	/**
	 */
	execute: function(){
		if (this.flag & Module.FLAG_EXECUTE) {
			this.process();
		}
		var self = this;
		var time = setTimeout(function(){
			clearTimeout(time);
			self.resolve();
		},timeout);
	},

	/**
	 */
	process: function(){
		if (this.exports != null) {
			return this.exports;
		}
		var imports = [],
			exports = this.exports = {};
		for (var i = 0; i < this.dependencies.length; ++i) {
			var name = this.dependencies[i];
			if (Object.prototype.hasOwnProperty.call(modules, name)) {
				var result = modules[name].process();
				if (modules[name].counter < 1) {
					imports.push(result);
					continue;
				}
			}
			waiting[name]||(waiting[name] = {});
			if (!waiting[name][this.name]) {
				waiting[name][this.name] = this;
				this.counter++;
			}
		}
		if (this.counter > 0) {
			this.exports = null;
		} else {
			exports = this.callback.apply(this, imports);
			if (exports != null) {
				this.exports = exports;
			}
		}
		return this.exports;
	},

	/**
	 */
	require: function(){
		if (this.exports != null) {
			return this.exports;
		}
		this.process();
		if (this.counter > 0) {
			throw new Error('Oops! Your module "' + this.name + '" still waiting for the dependencies.');
		}
		return this.exports;
	},

	/**
	 */
	resolve: function(){
		var waitings = waiting[this.name];
		if (!waitings) {
			return;
		}
		waiting[this.name] = null;
		for (var name in waitings) {
			if (!--waitings[name].counter) {
				if (waitings[name].flag & Module.FLAG_EXECUTE) {
					waitings[name].process();
				} else {
					waitings[name].resolve();
				}
			}
		}
	}
};

/**
 */
__.d = function(name, dependencies, callback, flag){
	var module = new Module(name, dependencies, callback, flag);
	if (Object.prototype.hasOwnProperty.call(modules, module.name)) {
		throw new Error('Oops! Your module "' + module.name + '" has already defined');
	}
	modules[module.name] = module;
	modules[module.name].execute();
};

/**
 */
__.r = function(name){
	if (!Object.prototype.hasOwnProperty.call(modules, name)) {
		throw new Error('Oops! We cannot find module "' + name + '"');
	}
	return modules[name].require();
};

})(window.__ = {});
