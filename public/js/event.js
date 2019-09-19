/**
 */
__.d('Event',[],function(){
/**
 */	
var Event = this.exports = function(){
	this._events = {};	
};
Event.prototype = {
	on:function(type, callback){
		if (typeof callback != 'function') throw new Error();
		this._events[type]||(this._events[type] = []);
		this._events[type].push(callback);
	},
	off:function(type, callback){
		if (!this._events[type]) return;
		var index = this._events[type].indexOf(callback);
		if (index > -1) this._events[type].splice(index, 1);
	},
	call:function(type){
		return this.apply(type, Array.prototype.slice.call(arguments, 1));
	},
	apply:function(type, args){
		if (!this._events[type]) return false;
		var events = Array.prototype.slice.call(this._events[type]),
			length = events.length;
		for (var i = 0; i < length; ++i) {
			events[i].apply(this, args);	
		}
		return true;
	},
	event:function(type){
		return this._events[type];
	},
	remove:function(type){
		delete this._events[type];
	},
	exists:function(type){
		return !!this._events[type];	
	}
};
	
});