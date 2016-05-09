/* wowslider modifications
 * add:
 * -   <link rel="stylesheet" type="text/css" href="engine1/style.mod.css" />
 * -   <script type="text/javascript" src="engine1/wowslider.mod.js"></script> (after "wowslider.js", before "script.js")
 *
 * wowslider-contaner, css-classes:
 * -   "playpause" : adds play/pause controll in slider
 * -   "fullscreen" : enable fullscreen-mode button
 * -   "hidecontrolls" : hide left on first slide and right on last
 * -   "hidetitles" : title and description only on mouse hover
 * -   "stoptitles" : title and description without animation
 * -   "delays" : enable delay for each slide
 *
 * ws_images(for each <li>-block) attributes:
 * -   "data-delay = %number%" : delay for this slide
 */
(function(b) {
	var a = b.fn.wowSlider;
	b.fn.wowSlider = function(p) {
		var N = p.autoPlay
		var e = b(".ws_images ul")[0].children
		var I = e.length
		var L = null
		var m
		var F = true
		if(this.hasClass("delays")) {
			p.autoPlay = false
			var l = new Array()
			for(var K = 0 ; K < I ; K++) {
				l[K] = b(e[K]).data("delay") || p.delay
			}
			function v() {
				clearTimeout(L)
				L = setTimeout(function() {
					if(N && m && ! F) {
						m[0].wsStart()
					} else {
						F = false
					}
					v()
				}
				, l[B] + p.duration)
			}
			v()
		}
		var t = p.onBeforeStep
		var k = p.onStep
		b.extend(p , {
			onBeforeStep:function(O , P) {
				if(! N && m) {
					m[0].wsStop()
					return O
				} else {
					if(t) {
						return t.apply(this , [O,P])
					} else {
						return O + 1
					}
				}
			} , onStep:function(O , P) {
				if(k) {
					k.apply(this , [O , P])
				}
				B = O
				if(j) {
					if(j.hasClass("delays")) {
						v()
					} if(j.hasClass("stoptitles")) {
						b(".ws-title, .ws-title>").stop(1 , 1).stop(1 , 1)
					} if(j.hasClass("hidecontrolls")) {
						y()
					}
				}
			}
		})
		m = a.apply(this , [p])
		var B = p.startSlide || 0
		var j = this
		var s = p.duration
		var M = null
		var d = false
		function y() {
			var P = b(".ws_prev")
			var i = b(".ws_next")
			try {
				if(B == 0) {
					P.css("display" , "none")
				} else {
					P.css("display" , "block")
				} if(B == I - 1) {
					i.css("display" , "none")
				} else {
					i.css("display" , "block")
				}
			} catch(O){}
		}
		if(j.hasClass("hidecontrolls")) {
			y()
		} if(j.hasClass("fullscreen")) {
			function g(P , O , i) {
				if(P.addEventListener) {
					P.addEventListener(O , i , false)
				} else {
					P.attachEvent("on" + O , i)
				}
			}
			function n(P , O , i) {
				if(P.removeEventListener) {
					P.removeEventListener(O , i)
				} else {
					P.detachEvent("on" + O , i)
				}
			}
			function J(Q , P) {
				if(! Q.length) {
					Q = [Q]
				}
				for(var R in P) {
					for(var O = 0 ; O < Q.length ; O++) {
						Q[O].style[R] = P[R]
					}
				}
			}
			var h = 0
			var q = ""
			if(typeof document.cancelFullScreen != "undefined") {
				h = true
			} else {
				var w = "webkit moz o ms khtml".split(" ")
				for(var K = 0 , x = w.length ; K < x ; K++) {
					q = w[K]
					if(typeof document[q + "CancelFullScreen"] != "undefined") {
						h = true
						break
					}
				}
			}
			function z(i) {
				if(h) {
					switch(q) {
						case"": {
							return document.fullScreen
						} case "webkit": {
							return document.webkitIsFullScreen
						} default: {
							return document[q+"FullScreen"]
						}
					}
				} else {
					return !! i.eh5v
				}
			}
			var c = 0
			var o = 0
			function C(Q) {
				if(h) {
					var P = p.width / (p.height + 100)
					var O = window.screen.availWidth
					b(Q).css({width:O})
					b(Q).children().css({top:(window.screen.availHeight - O / P) / 2})
					return (q === "") ? Q.requestFullScreen() : Q[q + "RequestFullScreen"]()
				} else {
					if(! Q) {
						return
					} if(c) {
						r(c)
					}
					var P = p.width / (p.height + 100)
					var O = b(window).width()
					var i = b("<div id='viewfullscreen'/>").css({position:"absolute",width:"100%",height:"100%","background-color":"#000",top:0,left:0,"z-index":9999999})
					i.appendTo("body")
					o = b(Q).children().css("max-width")
					i.append(b("<div id='container'/>").css({"margin-top":(b(window).height() - O / P) / 2}).append((b(Q).children().css({width:O,"max-width":"95%"}))))
					(function() {
						var R = b(".ws_shadow").css("background-image")
						R = R.replace("url(","").replace(")","").replace(/\/$/,"");b(".ws_shadow").css("background-image","none").append(b("<img src="+R+"></img>").css("width","100%"))
					})()
					g(document.body,"keydown",u)
					b("body").focus()
					d =! d
				}
			}
			function r(i) {
				if(h) {
					return(q === "") ? document.cancelFullScreen() : document[q + "CancelFullScreen"]()
				} else {
					if(! i) {
						return
					}
					(function() {
						var O = "url("+b(".ws_shadow>img").attr("src")+")"
						b(".ws_shadow").css("background-image",O).empty()
					})()
					b("#viewfullscreen>#container").children().css({width:"","max-width":o}).appendTo(b(i))
					b("#viewfullscreen").remove()
					n(document.body,"keydown",u)
					c = 0
					d =! d
				}
			}
			function u(i) {
				if(i.keyCode == 27) {
					H(true)
				}
			}
			b(document).on("webkitfullscreenchange mozfullscreenchange fullscreenchange",function() {
				d =! d
				b("")
				if(! d) {
					H(true)}
				})
			function H(O) {
				if(! O) {
					var i = b("<div id='fullscreen'/>")
					i.appendTo(j.parent())
					i.append(j)
					C(b("#fullscreen")[0])
					A.removeClass("min")
					A.addClass("max")
				} else {
					r(document)
					j.css({top:0})
					b("#fullscreen").parent().append(j)
					b("#fullscreen").remove()
					A.removeClass("max")
					A.addClass("min")
				}
				setTimeout(function() {
					b(".ws_thumbs").trigger("mousemove")
				} , 100)
			}
			var A = b('<a href="#" class="min ws_fulscreen" style="display: block;"></a>')
			A.click(function() {
				H(d)
			})
			j.append(A)
		} if(j.hasClass("playpause")) {
			var f = b('<a href="#" class="ws_playpause" style="display: block;"></a>')
			if(N) {
				f.addClass("pause")
			} else {
				f.addClass("play")
			}
			f.click(function() {
				N =! N
				if(! N) {
					if(! m.hasClass("delays")) {
						m[0].wsStop()
					}
					f.removeClass("pause")
					f.addClass("play")
				} else {
					if(! m.hasClass("delays")) {
						m[0].wsStart()
					}
					f.removeClass("play")
					f.addClass("pause")
				}
			})
			j.append(f)
		} if(j.hasClass("hidetitles")) {
			b(".ws-title").addClass("ws_hovershow")
			b(".ws_playpause").addClass("ws_hovershow")
			if(navigator.appName == "Microsoft Internet Explorer") {
				var D = - 1
				var G = navigator.userAgent
				var E = new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})")
				if(E.exec(G) != null) {
					D = parseFloat(RegExp.$1)
				} if(D != - 1 && D <= 8) {
					j.hover(function() {
						b(".ws_hovershow").animate({opacity:1},{
							step:function(i,O) {
								b(this).css("-ms-filter",'"progid:DXImageTransform.Microsoft.Alpha(Opacity="'+i+')"')
							} , duration:200} , 200)
					} , function() {
						b(".ws_hovershow").animate({opacity:0},{
							step:function(i , O) {
								b(this).css("-ms-filter",'"progid:DXImageTransform.Microsoft.Alpha(Opacity="'+i+')"')
							} , duration:200},200)
					})
				}
			}
		}
		return m
	}
})
(jQuery)
(function(b) {
	var a = b.fn.wowSlider
	b.fn.wowSlider = function(p) {
		var N = p.autoPlay
		var e = b(".ws_images ul")[0].children
		var I = e.length
		var L = null
		var m
		var F = true
		if(this.hasClass("delays")) {
			p.autoPlay = false
			var l = new Array()
			for(var K = 0 ; K < I ; K++) {
				l[K] = b(e[K]).data("delay") || p.delay
			}
			function v() {
				clearTimeout(L)
				L = setTimeout(function() {
					if(N && m && ! F) {
						m[0].wsStart()
					} else {
						F = false
					}
					v()
				} , l[B] + p.duration)
			}
			v()
		}
		var t = p.onBeforeStep
		var k = p.onStep
		b.extend(p , {
			onBeforeStep:function(O , P) {
				if(! N && m) {
					m[0].wsStop()
					return O
				} else {
					if(t) {
						return t.apply(this , [O , P])
					} else {
						return O + 1
					}
				}
			} , onStep:function(O , P) {
				if(k) {
					k.apply(this , [O , P])
				}
				B = O
				if(j) {
					if(j.hasClass("delays")) {
						v()
					} if(j.hasClass("stoptitles")) {
						b(".ws-title, .ws-title>").stop(1,1).stop(1,1)
					} if(j.hasClass("hidecontrolls")) {
						y()
					}
				}
			}
		})
		m = a.apply(this,[p])
		var B = p.startSlide || 0
		var j=this
		var s=p.duration
		var M=null
		var d=false
		function y() {
			var P=b(".ws_prev")
			var i=b(".ws_next")
			try {
				if(B == 0) {
					P.css("display","none")
				} else {
					P.css("display","block")
				} if (B == I - 1) {
					i.css("display","none")
				} else {
					i.css("display","block")
				}
			} catch(O){}
		}
		if(j.hasClass("hidecontrolls")) {
			y()
		} if(j.hasClass("fullscreen")) {
			function g(P , O , i) {
				if(P.addEventListener) {
					P.addEventListener(O , i , false)
				} else {
					P.attachEvent("on" + O , i)
				}
			}
			function n(P , O , i) {
				if(P.removeEventListener) {
					P.removeEventListener(O , i)
				} else {
					P.detachEvent("on" + O , i)
				}
			}
			function J(Q , P) {
				if(! Q.length) {
					Q = [Q]
				}
				for(var R in P) {
					for(var O = 0 ; O < Q.length ; O++) {
						Q[O].style[R]=P[R]
					}
				}
			}
			var h=0
			var q=""
			if(typeof document.cancelFullScreen != "undefined") {
				h=true
			} else {
				var w="webkit moz o ms khtml".split(" ")
				for(var K=0,x=w.length;K<x;K++) {
					q=w[K]
					if(typeof document[q+"CancelFullScreen"]!="undefined") {
						h=true
						break
					}
				}
			}
			function z(i) {
				if(h) {
					switch(q) {
						case"": {
							return document.fullScreen
						} case"webkit": {
							return document.webkitIsFullScreen
						} default: {
							return document[q+"FullScreen"]
						}
					}
				} else {
					return !! i.eh5v
				}
			}
			var c=0
			var o=0
			function C(Q) {
				if(h) {
					var P=p.width/(p.height+100)
					var O=window.screen.availWidth
					b(Q).css({width:O})
					b(Q).children().css({top:(window.screen.availHeight-O/P)/2})
					return (q==="")?Q.requestFullScreen():Q[q+"RequestFullScreen"]()
				} else {
					if(! Q) {
						return
					} if(c) {
						r(c)
					}
					var P=p.width/(p.height+100)
					var O=b(window).width()
					var i=b("<div id='viewfullscreen'/>").css({position:"absolute",width:"100%",height:"100%","background-color":"#000",top:0,left:0,"z-index":9999999})
					i.appendTo("body")
					o=b(Q).children().css("max-width")
					i.append(b("<div id='container'/>").css({"margin-top":(b(window).height()-O/P)/2}).append((b(Q).children().css({width:O,"max-width":"95%"}))))
					(function() {
						var R=b(".ws_shadow").css("background-image")
						R=R.replace("url(","").replace(")","").replace(/\/$/,"")
						b(".ws_shadow").css("background-image","none").append(b("<img src="+R+"></img>").css("width","100%"))
					})()
					g(document.body,"keydown",u)
					b("body").focus()
					d =! d
				}
			}
			function r(i) {
				if(h) {
					return (q==="") ?document.cancelFullScreen() : document[q+"CancelFullScreen"]()
				} else {
					if(! i) {
						return
					}
					(function() {
						var O="url("+b(".ws_shadow>img").attr("src")+")"
						b(".ws_shadow").css("background-image",O).empty()
					})()
					b("#viewfullscreen>#container").children().css({width:"","max-width":o}).appendTo(b(i))
					b("#viewfullscreen").remove()
					n(document.body,"keydown",u)
					c=0
					d=!d
				}
			}
			function u(i) {
				if(i.keyCode==27) {
					H(true)
				}
			}
			b(document).on("webkitfullscreenchange mozfullscreenchange fullscreenchange",function() {
				d=!d
				b("")
				if(!d) {
					H(true)
				}
			})
			function H(O) {
				if(!O) {
					var i=b("<div id='ws_fullscreen'/>")
					i.appendTo(j.parent())
					i.append(j)
					C(b("#ws_fullscreen")[0])
				} else {
					r(document)j.css({top:0})
					b("#ws_fullscreen").parent().append(j)
					b("#ws_fullscreen").remove()
				}
				setTimeout(function() {
					b(".ws_thumbs").trigger("mousemove")
				} , 100)
			}
			var A=b('<a href="#" class="min ws_fullscreen" style="display: block;"></a>')
			A.click(function() {
				H(d)
			})
			j.append(A)
		} if(j.hasClass("playpause")) {
			var f=b('<a href="#" class="ws_playpause ws_hovershow" style="display: block;"></a>')
			if(N) {
				f.addClass("pause")
			} else {
				f.addClass("play")
			}
			f.click(function() {
				N=!N
				if(!N) {
					if(!m.hasClass("delays")) {
						m[0].wsStop()
					}
					f.removeClass("pause")
					f.addClass("play")
				} else {
					if(!m.hasClass("delays")) {
						m[0].wsStart()
					}
					f.removeClass("play")
					f.addClass("pause")
				}
			})
			j.append(f)
		} if(j.hasClass("hidetitles")) {
			b(".ws-title").addClass("ws_hovershow")
			if(navigator.appName=="Microsoft Internet Explorer") {
				var D=-1
				var G=navigator.userAgent
				var E=new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})")
				if(E.exec(G)!=null) {
					D=parseFloat(RegExp.$1)
				} if(D!=-1&&D<=8) {
					j.hover(function() {
						b(".ws_hovershow").animate({opacity:1},{step:function(i,O) {
							b(this).css("-ms-filter",'"progid:DXImageTransform.Microsoft.Alpha(Opacity="'+i+')"')
						} , duration:200
					} , 200)} , function() {
							b(".ws_hovershow").animate({opacity:0},{step:function(i,O){b(this).css("-ms-filter",'"progid:DXImageTransform.Microsoft.Alpha(Opacity="'+i+')"')},duration:200},200)})}}}return m}})(jQuery);