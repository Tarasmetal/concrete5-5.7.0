var ccm_event=function(e,t){"use strict";ccm_event=function(){var e=t.createElement("span"),n=this;this.sub=function(t,n,r){r=r||e;r.addEventListener?r.addEventListener(t.toLowerCase(),n,0):r.attachEvent("on"+t.toLowerCase(),n)};this.pub=function(n,r,i){var s=i||e,o=n.toLowerCase();t.createEvent?(i=t.createEvent("HTMLEvents"),i.initEvent(o,1,1)):(i=t.createEventObject(),i.eventType=o);i.eventName="CCMEvent";i.eventData=r||{};t.createEvent?s.dispatchEvent(i):s.fireEvent("on"+i.eventType,i);"function"==typeof s["on"+n.toLowerCase()]&&s["on"+n.toLowerCase()](i)};n.subscribe=n.bind=n.watch=n.on=n.sub;n.publish=n.fire=n.trigger=n.do=n.pub;return n};return new ccm_event}(window,document);window.ccm_subscribe=ccm_event.sub;window.ccm_publish=ccm_event.pub;