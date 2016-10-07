(function() {
    var aa = {
            stop_browser_behavior: {
                userSelect: "none",
                touchCallout: "none",
                touchAction: "none",
                contentZooming: "none",
                userDrag: "none",
                tapHighlightColor: "rgba(0,0,0,0)"
            }
        },
        ca = navigator.pointerEnabled || navigator.msPointerEnabled,
        da = {},
        ea = "move",
        n = "end",
        fa = !1;

    function ha(a) {
        return function() {
            if (1 <= arguments.length) {
                var c = arguments[0];
                if ("pageX" in c && !c.pageX && c.clientX) {
                    var b = c.target.ownerDocument || document,
                        d = b.documentElement,
                        b = b.body;
                    c.pageX_ || (c.pageX_ = c.clientX + (d && d.scrollLeft || b && b.scrollLeft || 0) - (d && d.clientLeft || b && b.clientLeft || 0));
                    c.pageY_ || (c.pageY_ = c.clientY + (d && d.scrollTop || b && b.scrollTop || 0) - (d && d.clientTop || b && b.clientTop || 0))
                }
            }
            a.apply(this, arguments)
        }
    }

    function v(a) {
        return "pageX_" in a ? a.pageX_ : a.pageX
    }

    function G(a) {
        return "pageY_" in a ? a.pageY_ : a.pageY
    }

    function ja() {
        if (!fa) {
            ka.Bd();
            for (var a in I) I.hasOwnProperty(a) && J.Ee(I[a]);
            ka.Bb(document, ea, J.gb);
            ka.Bb(document, n, J.Jd);
            fa = !0
        }
    }

    function la(a, c) {
        var b = this;
        ja();
        this.element = a;
        this.enabled = !0;
        this.options = K.extend(K.extend({}, aa), c || {});
        this.options.Qe && K.Pe(this.element, this.options.Qe);
        ka.Bb(a, "start", function(a) {
            b.enabled && J.Oe(b, a)
        });
        return this
    }
    la.prototype = {
        ja: function(a, c) {
            for (var b = a.split(" "), d = 0; d < b.length; d++) this.element.addEventListener(b[d], ha(c), !1);
            return this
        }
    };

    function P(a, c, b) {
        var d = document.createEvent("Event");
        d.initEvent(c, !0, !0);
        d.dc = b;
        a.element.dispatchEvent(d)
    }
    var ma = null,
        na = !1,
        oa = !1,
        ka = function() {
            var a = {
                qd: function(a, b, d) {
                    b = b.split(" ");
                    for (var e = 0; e < b.length; e++) a.addEventListener(b[e], ha(d), !1)
                },
                Bb: function(c, b, d) {
                    a.qd(c, da[b], function(e) {
                        var f = e.type.toLowerCase();
                        if (f.match(/mouseup/) && oa) oa = !1;
                        else {
                            if (f.match(/touch/) || f.match(/mouse/) && 1 === e.which || ca && f.match(/down/)) na = !0;
                            f.match(/touch|pointer/) && (oa = !0);
                            !na || oa && f.match(/mouse/) || (ca && b != n && pa.ed(b, e), b === n && null !== ma ? e = ma : ma = e, d.call(J, a.sd(c, b, e)), ca && b == n && pa.ed(b, e));
                            f.match(/up|cancel|end/) &&
                                (na = !1, ma = null, pa.reset())
                        }
                    })
                },
                Bd: function() {
                    var a;
                    a = ca ? ["pointerdown MSPointerDown", "pointermove MSPointerMove", "pointerup pointercancel MSPointerUp MSPointerCancel"] : ["touchstart mousedown", "touchmove mousemove", "touchend touchcancel mouseup"];
                    da.start = a[0];
                    da[ea] = a[1];
                    da[n] = a[2]
                },
                kb: function(a) {
                    return ca ? pa.kb() : a.touches ? a.touches : [{
                        identifier: 1,
                        pageX: v(a),
                        pageY: G(a),
                        target: a.target
                    }]
                },
                sd: function(c, b, d) {
                    c = a.kb(d, b);
                    var e = "touch";
                    if (d.type.match(/mouse/) || pa.ie("mouse", d)) e = "mouse";
                    return {
                        G: K.Qd(c),
                        timestamp: d.timestamp || (new Date).getTime(),
                        target: d.target,
                        touches: c,
                        aa: b,
                        pointerType: e,
                        Ne: d,
                        preventDefault: function() {
                            d.re && d.re();
                            d.preventDefault && d.preventDefault()
                        },
                        stopPropagation: function() {
                            d.stopPropagation()
                        },
                        Ta: function() {
                            return J.Ta()
                        }
                    }
                }
            };
            return a
        }(),
        pa = function() {
            var a = {
                Pa: {},
                kb: function() {
                    var c = a.Pa,
                        b = [];
                    null != c && Object.keys(c).sort().forEach(function(a) {
                        b.push(c[a])
                    });
                    return b
                },
                ed: function(c, b) {
                    c == n ? delete a.Pa[b.pointerId] : (b.identifier = b.pointerId, a.Pa[b.pointerId] = b)
                },
                ie: function(a,
                    b) {
                    if (!b.pointerType) return !1;
                    var d = {};
                    d.mouse = b.pointerType == b.MSPOINTER_TYPE_MOUSE || "mouse" == b.pointerType;
                    d.touch = b.pointerType == b.MSPOINTER_TYPE_TOUCH || "touch" == b.pointerType;
                    d.pen = b.pointerType == b.MSPOINTER_TYPE_PEN || "pen" == b.pointerType;
                    return d[a]
                },
                nf: function() {
                    return ["pointerdown MSPointerDown", "pointermove MSPointerMove", "pointerup pointercancel MSPointerUp MSPointerCancel"]
                },
                reset: function() {
                    a.Pa = {}
                }
            };
            return a
        }(),
        K = function() {
            var a = {
                extend: function(a, b) {
                    for (var d in b) a[d] = b[d];
                    return a
                },
                Qd: function(a) {
                    for (var b = [], d = [], e = 0, f = a.length; e < f; e++) b.push(v(a[e])), d.push(G(a[e]));
                    return {
                        pageX: (Math.min.apply(Math, b) + Math.max.apply(Math, b)) / 2,
                        pageY: (Math.min.apply(Math, d) + Math.max.apply(Math, d)) / 2
                    }
                },
                Ud: function(a, b, d) {
                    return {
                        x: Math.abs(b / a) || 0,
                        y: Math.abs(d / a) || 0
                    }
                },
                jb: function(a, b) {
                    return 180 * Math.atan2(G(b) - G(a), v(b) - v(a)) / Math.PI
                },
                Rd: function(a, b) {
                    return Math.abs(v(a) - v(b)) >= Math.abs(G(a) - G(b)) ? 0 < v(a) - v(b) ? "left" : "right" : 0 < G(a) - G(b) ? "up" : "down"
                },
                Ha: function(a, b) {
                    var d = v(b) - v(a),
                        e = G(b) -
                        G(a);
                    return Math.sqrt(d * d + e * e)
                },
                Td: function(c, b) {
                    return 2 <= c.length && 2 <= b.length ? a.Ha(b[0], b[1]) / a.Ha(c[0], c[1]) : 1
                },
                Sd: function(c, b) {
                    return 2 <= c.length && 2 <= b.length ? a.jb(b[1], b[0]) - a.jb(c[1], c[0]) : 0
                },
                qb: function(a) {
                    return "up" == a || "down" == a
                },
                Pe: function(a, b) {
                    var d, e = "webkit khtml moz ms o ".split(" ");
                    if (b && a.style) {
                        for (var f = 0; f < e.length; f++)
                            for (var k in b) b.hasOwnProperty(k) && (d = k, e[f] && (d = e[f] + d.substring(0, 1).toUpperCase() + d.substring(1)), a.style[d] = b[k]);
                        "none" == b.Af && (a.onselectstart = function() {
                            return !1
                        })
                    }
                }
            };
            return a
        }(),
        J = function() {
            var a = {
                ua: [],
                i: null,
                Nc: null,
                Ua: !1,
                Oe: function(c, b) {
                    a.i || (a.Ua = !1, a.i = {
                        pc: c,
                        Kb: K.extend({}, b),
                        ub: !1,
                        name: ""
                    }, a.gb(b))
                },
                gb: function(c) {
                    if (a.i && !J.Ua) {
                        c = a.Md(c);
                        for (var b = a.i.pc.options, d = 0, e = a.ua.length; d < e; d++) {
                            var f = a.ua[d];
                            if (!a.Ua && !1 !== b[f.name] && !1 === f.ca.call(f, c, a.i.pc)) {
                                a.Ta();
                                break
                            }
                        }
                        a.i && (a.i.ub = c)
                    }
                },
                Jd: function(c) {
                    a.gb(c);
                    a.Ta()
                },
                Ta: function() {
                    a.Nc = K.extend({}, a.i);
                    a.i = null;
                    a.Ua = !0
                },
                Md: function(c) {
                    var b = a.i.Kb;
                    if (b && (c.touches.length != b.touches.length || c.touches ===
                            b.touches)) {
                        b.touches = [];
                        for (var d = 0, e = c.touches.length; d < e; d++) b.touches.push(K.extend({}, c.touches[d]))
                    }
                    var d = c.timestamp - b.timestamp,
                        e = v(c.G) - v(b.G),
                        f = G(c.G) - G(b.G),
                        k = K.Ud(d, e, f);
                    K.extend(c, {
                        xd: d,
                        yd: e,
                        zd: f,
                        velocityX: k.x,
                        velocityY: k.y,
                        hb: K.Ha(b.G, c.G),
                        Aa: K.jb(b.G, c.G),
                        direction: K.Rd(b.G, c.G),
                        scale: K.Td(b.touches, c.touches),
                        rotation: K.Sd(b.touches, c.touches),
                        Kb: b
                    });
                    return c
                },
                Ee: function(c) {
                    var b = c.H || {};
                    "undefined" == typeof b[c.name] && (b[c.name] = !0);
                    K.extend(aa, b);
                    c.index = c.index || 1E3;
                    a.ua.push(c);
                    a.ua.sort(function(a, b) {
                        return a.index < b.index ? -1 : a.index > b.index ? 1 : 0
                    });
                    return a.ua
                }
            };
            return a
        }(),
        I = I || {};
    I.cf = function() {
        var a = {
            name: "hold",
            index: 10,
            H: {
                ae: 500,
                $d: 1
            },
            Va: null,
            ca: function(c, b) {
                switch (c.aa) {
                    case "start":
                        clearTimeout(a.Va);
                        J.i.name = a.name;
                        a.Va = setTimeout(function() {
                            J.i.name == a.name && P(b, a.name, c)
                        }, b.options.ae);
                        break;
                    case ea:
                        c.hb > b.options.$d && clearTimeout(a.Va);
                        break;
                    case n:
                        clearTimeout(a.Va)
                }
            }
        };
        return a
    }();
    I.ff = {
        name: "tap",
        index: 100,
        H: {
            Se: 250,
            Re: 10,
            Cd: 20,
            Dd: 300
        },
        ca: function(a, c) {
            if (a.aa == n) {
                var b = J.Nc;
                a.xd > c.options.Se || a.hb > c.options.Re || (J.i.name = b && "tap" == b.name && a.timestamp - b.ub.timestamp < c.options.Dd && K.Ha(a.G, b.Kb.G) < c.options.Cd ? "doubletap" : "tap", P(c, J.i.name, a))
            }
        }
    };
    I.ef = function() {
        var a = {
            name: "swipe",
            index: 40,
            H: {
                Qc: 1,
                Rc: 0.7
            },
            ca: function(c, b) {
                c.aa != n || 0 < b.options.Qc && c.touches.length > b.options.Qc || !(c.velocityX > b.options.Rc || c.velocityY > b.options.Rc) || (P(b, a.name, c), P(b, a.name + c.direction, c))
            }
        };
        return a
    }();
    I.bf = function() {
        var a = {
            name: "drag",
            index: 50,
            H: {
                Hd: 10,
                Zb: 1,
                Ed: !1,
                Fd: !1,
                Gd: !1
            },
            u: !1,
            ca: function(c, b) {
                if (J.i.name != a.name && a.u) P(b, a.name + "end", c), a.u = !1;
                else if (!(0 < b.options.Zb && c.touches.length > b.options.Zb)) switch (c.aa) {
                    case "start":
                        a.u = !1;
                        break;
                    case ea:
                        if (c.hb < b.options.Hd && J.i.name != a.name) break;
                        J.i.name = a.name;
                        var d = J.i.ub.direction;
                        b.options.Gd && d !== c.direction && (c.direction = K.qb(d) ? 0 > c.zd ? "up" : "down" : 0 > c.yd ? "left" : "right");
                        a.u || (P(b, a.name + "start", c), a.u = !0);
                        P(b, a.name, c);
                        P(b, a.name + c.direction,
                            c);
                        (b.options.Fd && K.qb(c.direction) || b.options.Ed && !K.qb(c.direction)) && c.preventDefault();
                        break;
                    case n:
                        a.u && P(b, a.name + "end", c), a.u = !1
                }
            }
        };
        return a
    }();
    I.hf = function() {
        var a = {
            name: "transform",
            index: 45,
            H: {
                dd: 0.01,
                cd: 1,
                Ye: !1
            },
            u: !1,
            ca: function(c, b) {
                if (J.i.name != a.name && a.u) P(b, a.name + "end", c), a.u = !1;
                else if (!(2 > c.touches.length)) switch (b.options.Ye && c.preventDefault(), c.aa) {
                    case "start":
                        a.u = !1;
                        break;
                    case ea:
                        var d = Math.abs(1 - c.scale),
                            e = Math.abs(c.rotation);
                        if (d < b.options.dd && e < b.options.cd) break;
                        J.i.name = a.name;
                        a.u || (P(b, a.name + "start", c), a.u = !0);
                        P(b, a.name, c);
                        e > b.options.cd && P(b, "rotate", c);
                        d > b.options.dd && (P(b, "pinch", c), P(b, "pinch" + (1 > c.scale ? "in" :
                            "out"), c));
                        break;
                    case n:
                        a.u && P(b, a.name + "end", c), a.u = !1
                }
            }
        };
        return a
    }();
    I.gf = function() {
        var a = {
            name: "touch",
            index: -Infinity,
            H: {
                Db: !1
            },
            ca: function(c, b) {
                b.options.Db && c.preventDefault();
                "start" == c.aa && P(b, a.name, c)
            }
        };
        return a
    }();
    I.df = function() {
        var a = {
            name: "release",
            index: Infinity,
            ca: function(c, b) {
                c.aa == n && P(b, a.name, c)
            }
        };
        return a
    }();
    var Q = function() {
        var a = {},
            c = Array.prototype,
            b = Object.prototype,
            d = c.slice,
            e = c.concat,
            f = b.toString,
            k = b.hasOwnProperty,
            b = Object.keys,
            g = c.forEach,
            m = c.filter,
            l = c.map;
        a.isArray = Array.isArray || function(a) {
            return "[object Array]" == f.call(a)
        };
        a.tf = function(a) {
            return "[object Arguments]" == f.call(a)
        };
        a.X = function(a) {
            return "[object Function]" == f.call(a)
        };
        a.pb = function(a) {
            return "[object String]" == f.call(a)
        };
        a.La = function(a) {
            return "[object Number]" == f.call(a)
        };
        a.uf = function(a) {
            return "[object Date]" == f.call(a)
        };
        a.vf =
            function(a) {
                return "[object RegExp]" == f.call(a)
            };
        a.j = function(a) {
            return void 0 === a
        };
        a.da = function(a) {
            return a === Object(a)
        };
        a.kf = function(a, b, c) {
            c || (c = 1E-6);
            a -= b;
            return a < c && a > -c
        };
        a.N = function(b, c) {
            return a.da(b) ? c in b : !1
        };
        a.hasOwnProperty = function(a, b) {
            return k.call(a, b)
        };
        a.forEach = function(b, c, e) {
            if (null != b)
                if (g && b.forEach === g) b.forEach(c, e);
                else if (b.length === +b.length)
                for (var d = 0, f = b.length; d < f; d++) c.call(e, b[d], d, b);
            else
                for (d in b) a.hasOwnProperty(b, d) && c.call(e, b[d], d, b)
        };
        a.filter = function(b,
            c, e) {
            if (null == b) return [];
            if (m && b.filter === m) return b.filter(c, e);
            var d = [];
            a.forEach(b, function(a, b, f) {
                c.call(e, a, b, f) && d.push(a)
            });
            return d
        };
        a.map = function(b, c, e) {
            if (null == b) return [];
            if (l && b.map === l) return b.map(c, e);
            var d = [];
            a.forEach(b, function(a, b, f) {
                d.push(c.call(e, a, b, f))
            });
            return d
        };
        a.extend = function(a, b) {
            for (var c = 1, e = arguments.length; c < e; c++) {
                var d = arguments[c],
                    f;
                for (f in d) a[f] = d[f]
            }
            return a
        };
        a.keys = b || function(b) {
            if (!a.da(b)) throw new TypeError;
            var c = [],
                e;
            for (e in b) a.hasOwnProperty(b, e) &&
                c.push(e);
            return c
        };
        a.oe = function(a, b) {
            for (var f = {}, g = e.apply(c, d.call(arguments, 1)), k = 0, l = g.length; k < l; k++) {
                var m = g[k];
                m in a && (f[m] = a[m])
            }
            return f
        };
        a.qa = function(b) {
            return a.isArray(b) ? b.slice() : a.extend({}, b)
        };
        a.H = function(b, c) {
            a.forEach(d.call(arguments, 1), function(a) {
                for (var c in a) null == b[c] && (b[c] = a[c])
            });
            return b
        };
        a.contains = function(a, b) {
            return null == a ? !1 : -1 != a.indexOf(b)
        };
        a.Nd = function(b) {
            for (var c = 0, e = arguments.length; c < e; c++)
                if (!a.j(arguments[c])) return arguments[c]
        };
        return a
    }();
    var qa = function() {
        var a = window.performance && (window.performance.now || window.performance.mozNow || window.performance.msNow || window.performance.oNow || window.performance.webkitNow);
        return function() {
            return a && a.call(window.performance) || (new Date).getTime()
        }
    }();
    var R, ra, sa, ta, ua;
    (function() {
        function a(a) {
            return function(b) {
                return 1 > (b *= 2) ? 0.5 * Math.pow(b, a) : 1 - 0.5 * Math.abs(Math.pow(2 - b, a))
            }
        }
        R = function(a) {
            return a
        };
        ra = function(a) {
            return function(b) {
                return Math.pow(b, a)
            }
        }(3);
        sa = function(a) {
            return function(b) {
                return 1 - Math.pow(1 - b, a)
            }
        }(3);
        ta = a(3);
        ua = a(2)
    })();

    function va() {
        function a(a) {
            if (!a.type) throw "Events must have a type.";
            for (var b = "on" + a.type.substr(0, 1).toUpperCase() + a.type.substring(1), f = c.slice(0), k = 0; k < f.length; k++) {
                var g = f[k][b];
                g && g.call(g, a);
                if (!0 === a.stopPropagation) break
            }
        }
        var c = [],
            b;
        this.addEventListener = function(a) {
            c.push(a)
        };
        this.removeEventListener = function(a) {
            for (var b = 0; b < c.length; b++) c[b] === a && c.splice(b, 1)
        };
        this.Jb = function(a) {
            b = a
        };
        this.C = function(b) {
            a(b);
            !0 !== b.stopPropagation && wa(this, function(a) {
                a.C && a.C(b)
            })
        };
        this.W = function(c) {
            a(c);
            b && b.W(c)
        };
        return this
    }

    function xa() {
        va.call(this);
        var a = this;
        a.addEventListener({
            onAddedToStage: function(c) {
                a.xa = c.xa;
                a.Jb(c.xa)
            },
            onRemovedFromStage: function() {
                a.xa = void 0;
                a.Jb(void 0)
            }
        });
        a.A = function() {
            a.W({
                type: "dirty",
                target: this
            })
        };
        return a
    }

    function ya() {
        va.call(this);
        this.sc = this.children = [];
        this.ge = {};
        this.Pb = function(a, c) {
            this.sc.push(c);
            this.ge[a] = c;
            c.Jb(this)
        }
    }

    function za(a, c) {
        function b() {
            d.C({
                type: "paint"
            })
        }
        va.call(this);
        this.children = [];
        this.name = c ? c : "unnamed";
        this.canvas = a;
        this.J = a.getContext("2d");
        var d = this,
            e = !1;
        this.addEventListener({
            onDirty: function() {
                e || (e = !0, Aa.Mc(b))
            },
            onPaint: function(b) {
                a = a || this.canvas;
                var c = a.getContext("2d");
                c.clearRect(0, 0, a.width, a.height);
                b.J = c;
                e = !1
            },
            onLayout: function(a) {
                var b = d.canvas;
                if (b.width != a.e || b.height != a.d) b.width = a.e, b.height = a.d
            }
        });
        this.Za = function(a) {
            for (var b = 0; b < arguments.length; b++) this.children.push(arguments[b]),
                arguments[b].C({
                    type: "addedToStage",
                    xa: d
                })
        };
        this.Gb = function(a) {
            for (var b = 0; b < arguments.length; b++)
                for (var c = 0; c < this.children.length;) this.children[c] === arguments[b] ? (this.children.splice(c, 1), arguments[b].C({
                    type: "removedFromStage",
                    xa: d
                })) : c++
        }
    };
    var Ba = new function() {
        this.pe = function(a, c) {
            for (var b = 0; b < a.length; b++) {
                var d = a[b],
                    e = a[b + 1] || a[0];
                if (0 > (c.y - d.y) * (e.x - d.x) - (c.x - d.x) * (e.y - d.y)) return !1
            }
            return !0
        };
        this.qe = function(a, c) {
            return a.x >= c.x && a.y >= c.y && a.x <= c.x + c.e && a.y <= c.y + c.d
        };
        this.Od = function(a, c) {
            a.beginPath();
            var b = c[0];
            a.moveTo(b.x, b.y);
            for (var d = 1; d < c.length; d++) b = c[d], a.lineTo(b.x, b.y)
        };
        return this
    };
    var Ca = new function() {
        function a(a, b, f, k, g, m) {
            a.font = f + "px " + k;
            k = 0;
            for (var l = [], q = !0; !(0 == b.length || k + g > m.d);) {
                var p = c(a, b, m.e);
                p.x = 0;
                p.y = k;
                l.push(p);
                b = p.Sc;
                q = q && p.Ea;
                k += g
            }
            return {
                p: l,
                sa: f,
                Nb: 0 < b.length,
                Ea: q
            }
        }

        function c(a, b, c) {
            b = b.trim();
            for (var k = 0, g = b.length + 1; 1 < g - k;) {
                var m = Math.floor((g + k) / 2),
                    l = a.measureText(b.substring(0, m)).width;
                if (l == c) {
                    k = m;
                    break
                }
                l < c ? k = m : g = m
            }
            c = !0;
            if (k < b.length) {
                for (g = k; 0 < g && " " != b.charAt(g);) g--;
                (c = 0 < g) && (k = g)
            }
            g = b.substring(0, k);
            return {
                text: g,
                width: a.measureText(g).width,
                Sc: b.substring(k).trim(),
                Ea: c
            }
        }
        this.cc = function(d, e, f, k, g, m, l, q, p) {
            if (Q.pb(e)) {
                l = Number(l);
                var t = String.fromCharCode(8230),
                    s = p ? p.Na : void 0;
                if (!s) {
                    d.textBaseline = "top";
                    g = Math.floor(g);
                    m = Math.floor(m);
                    var y, u;
                    if (1 >= m - g)
                        for (y = m; y >= g; y--) {
                            if (u = a(d, e, y, k, y + l, f), !u.Nb && u.Ea) {
                                s = u;
                                break
                            }
                        } else
                            for (; 1 < m - g;) y = Math.floor((m + g) / 2), u = a(d, e, y, k, y + l, f), u.Nb || !u.Ea ? m = y : (g = y, s = u);
                    s || (s = u);
                    if (s) {
                        if (s.Nb && 0 < s.p.length)
                            for (d.font = s.sa + "px " + k, u = s.p[s.p.length - 1], g = u.text; 0 < g.length;) {
                                for (e = g.length - 1; 0 < e && " " == g.charCodeAt(e);) e--;
                                g = g.substring(0,
                                    e);
                                e = c(d, g + t, f.e);
                                if (0 == e.Sc.length) {
                                    s.p.pop();
                                    e.x = 0;
                                    e.y = u.y;
                                    s.p.push(e);
                                    break
                                }
                            }
                        u = 0;
                        g = s.sa + l;
                        for (t = 0; t < s.p.length; t++) e = s.p[t], u = Math.max(e.y + g, u);
                        e = (f.d - u) / 2;
                        for (t = 0; t < s.p.length; t++) s.p[t].y += e;
                        for (t = 0; t < s.p.length; t++) e = s.p[t], e.x = (f.e - e.width) / 2;
                        if (p) {
                            e = s.p;
                            if (0 < e.length)
                                for (l = s.Sb = {
                                        x: e[0].x,
                                        y: e[0].y,
                                        e: e[0].width,
                                        d: (s.sa + l) * e.length
                                    }, t = 1; t < e.length; t++) l.x = Math.min(l.x, e[t].x), l.e = Math.max(l.e, e[t].width);
                            p.Na = s
                        }
                    }
                }
                if (s)
                    for (d.font = s.sa + "px " + k, d.fillStyle = q, t = 0; t < s.p.length; t++) e = s.p[t], d.fillText(e.text,
                        f.x + e.x, f.y + e.y + (b ? 0.1 : -0.1) * s.sa)
            }
        };
        var b = /Firefox/.test(navigator.userAgent);
        return this
    };
    var Da = 2 * Math.PI,
        Ea = "SE",
        Fa = "SW",
        Ga = "NE",
        Ha = "NW";

    function S(a) {
        return a * Math.PI / 180
    }

    function Ia(a) {
        if (0 <= a && 360 > a) return a;
        a %= 360;
        return 0 > a ? a + 360 : a
    }

    function Ja(a) {
        if (0 <= a && a < Da) return a;
        a %= Da;
        return 0 > a ? Da + a : a
    }

    function Ka(a, c) {
        if (a == c) return 0;
        if (0 > a || a > Da) a = Ja(a);
        if (0 > c || c > Da) c = Ja(c);
        return a < c ? c - a : a > Math.PI ? Da - a + c : Da - c + a
    };
    var Aa = function() {
        function a() {
            if (!m) throw "Panic. onFrame called from unregistered state?";
            var a = qa();
            g = g.filter(function(a) {
                return null !== a
            });
            d.frames++;
            d.ve = g.length;
            d.xc = Math.max(d.xc, g.length);
            for (var b = 0; b < g.length; b++) {
                var p = g[b];
                null !== p && (p.Ub.call(p.J), Q.La(p.repeat) && (p.repeat -= 1, 0 >= p.repeat && (g[b] = null)))
            }
            a = qa() - a;
            d.totalTime += a;
            d.wc = Math.max(d.wc, a);
            e += a;
            for (d.ta.push(a); d.ta.length > f;) e -= d.ta.shift();
            d.Pd = d.ta.length / (e / 1E3);
            d.Xe = e / d.ta.length;
            g = g.filter(function(a) {
                return null !== a
            });
            m = !1;
            c()
        }

        function c() {
            0 < g.length && !m && (m = !0, k(a))
        }
        var b = {},
            d = b.zf = {
                frames: 0,
                totalTime: 0,
                Xe: 0,
                Pd: 0,
                ve: 0,
                xc: 0,
                wc: 0,
                ta: []
            },
            e = 0,
            f = 100,
            k = function() {
                return /iPad|iPhone/.test(window.navigator.userAgent) ? function(a) {
                    window.setTimeout(a, 0)
                } : window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(a) {
                    var b = 0;
                    window.setTimeout(function() {
                        var c = qa();
                        a();
                        b = qa() - c
                    }, 16 > b ? 16 - b : 0)
                }
            }(),
            g = [],
            m = !1;
        b.repeat =
            function(a, e, d) {
                b.cancel(a);
                g.push({
                    Ub: a,
                    J: d,
                    repeat: e
                });
                c()
            };
        b.Mc = function(a) {
            b.repeat(a, 1, void 0)
        };
        b.cancel = function(a) {
            for (var b = 0; b < g.length; b++) {
                var c = g[b];
                null !== c && c.Ub === a && (g[b] = null)
            }
        };
        return b
    }();
    var W = function() {
        function a(a, b, m) {
            var l = this,
                q;
            this.id = e++;
            this.name = m ? m : "{unnamed on " + a + "}";
            this.target = function() {
                return a
            };
            this.nb = function() {
                return -1 != f.indexOf(l)
            };
            this.start = function() {
                if (!l.nb()) {
                    if (-1 == f.indexOf(l)) {
                        var a = qa();
                        !0 === l.Ec(a) && (f = f.slice(), f.push(l))
                    }
                    0 < f.length && Aa.repeat(c)
                }
                return this
            };
            this.stop = function() {
                d(l);
                return this
            };
            this.Oc = function() {
                q = void 0
            };
            this.Ec = function(a) {
                if (0 !== b.length) {
                    var c;
                    Q.j(q) ? (q = 0, c = b[q], c.ha && c.ha.call(c, a, l)) : c = b[q];
                    for (; q < b.length;) {
                        if (c.ia &&
                            c.ia.call(c, a, l)) return !0;
                        c.ld && c.ld.call(c, a, l);
                        Q.j(q) && (q = -1);
                        ++q < b.length && (c = b[q], c.ha && c.ha.call(c, a, l))
                    }
                }
                return !1
            }
        }

        function c() {
            b();
            0 == f.length && Aa.cancel(c)
        }

        function b() {
            var a = qa();
            f.forEach(function(b) {
                !0 !== b.Ec(a) && d(b)
            })
        }

        function d(a) {
            f = f.filter(function(b) {
                return b !== a
            })
        }
        var e = 0,
            f = [];
        a.kd = function(a) {
            return Q.j(a) ? f.slice() : f.filter(function(b) {
                return b.target() === a
            })
        };
        a.F = function() {
            function b() {
                throw "No instances.";
            }

            function c(a) {
                var b = a.target,
                    e = a.duration,
                    d = a.O,
                    f, g;
                this.ha = function() {
                    f = {};
                    for (var c in a.k) c in b && (f[c] = {
                        start: Q.j(a.k[c].start) ? b[c] : Q.X(a.k[c].start) ? a.k[c].start.call(void 0) : a.k[c].start,
                        end: Q.j(a.k[c].end) ? b[c] : Q.X(a.k[c].end) ? a.k[c].end.call(void 0) : a.k[c].end,
                        f: Q.j(a.k[c].f) ? R : a.k[c].f
                    });
                    g = qa()
                };
                this.ia = function() {
                    var a = qa() - g,
                        a = 0 === e ? 1 : Math.min(e, a) / e,
                        c;
                    for (c in f) {
                        var k = f[c];
                        b[c] = k.start + (k.end - k.start) * k.f(a)
                    }
                    d && d.call(b, a);
                    return 1 > a
                }
            }

            function e(a, b) {
                this.ia = function() {
                    a.call(b);
                    return !1
                }
            }

            function d(a) {
                var b;
                this.ha = function(c) {
                    b = c + a
                };
                this.ia = function(a) {
                    return a <
                        b
                }
            }

            function f(a) {
                if (!Array.isArray(a)) throw "An array of timelines required.";
                this.ha = function() {
                    a.forEach(function(a) {
                        a.start()
                    })
                };
                this.ia = function() {
                    for (var b = 0; b < a.length; b++)
                        if (a[b].nb()) return !0;
                    return !1
                }
            }
            b.ja = function(b, k) {
                return new function() {
                    var s = [];
                    this.pa = function(a) {
                        s.push(a);
                        return this
                    };
                    this.gd = function(a) {
                        return this.pa(new d(a))
                    };
                    this.call = function(a, c) {
                        Q.j(c) && (c = b);
                        return this.pa(new e(a, c))
                    };
                    this.V = function(a) {
                        Q.j(a.target) && (a.target = b);
                        return this.pa(new c(a))
                    };
                    this.Cb = function(a) {
                        return this.pa(new f(a))
                    };
                    this.Oc = function() {
                        return this.pa({
                            ia: function(a, b) {
                                b.Oc();
                                return !0
                            }
                        })
                    };
                    this.Ga = function() {
                        return new a(b, s, k)
                    };
                    this.start = function() {
                        return this.Ga().start()
                    }
                }
            };
            b.I = function(c, e) {
                a.kd(c).forEach(function(a) {
                    a.stop()
                });
                return b.ja(c, e)
            };
            return b
        }();
        return a
    }();
    var La = new function() {
        function a(a, b, d, e, f, k, g, m, l, q, p, t, s, y) {
            var u, N;
            a.save();
            a.beginPath();
            a.moveTo(d, e);
            a.lineTo(f, k);
            a.lineTo(g, m);
            a.clip();
            f -= d;
            k -= e;
            g -= d;
            m -= e;
            p -= l;
            t -= q;
            s -= l;
            y -= q;
            u = p * y - s * t;
            0 != u && (N = 1 / u, u = (y * f - t * g) * N, t = (y * k - t * m) * N, f = (p * g - s * f) * N, k = (p * m - s * k) * N, a.transform(u, t, f, k, d - u * l - f * q, e - t * l - k * q), a.drawImage(b, 0, 0));
            a.restore()
        }
        this.he = function(c, b, d, e, f, k, g, m, l, q, p, t, s, y, u, N, ga, O) {
            l = Math.ceil((m - g) / l);
            k = Math.ceil((f - e) / k);
            if (!(0 >= l || 0 >= k)) {
                var T = function(a, c) {
                        var r = (a - g) / (m - g),
                            ba = (c - e) / (f -
                                e);
                        N && (r = 1 - r);
                        ga || (ba = 1 - ba);
                        if (u) var Xa = r,
                            r = ba,
                            ba = Xa;
                        return {
                            x: b + c * Math.cos(a),
                            y: d + c * Math.sin(a),
                            la: p + s * r,
                            ma: t + y * ba
                        }
                    },
                    Z = O && O.Tc;
                O = O.Te;
                for (var H = (m - g) / l, h = (f - e) / k, D = 0; D < k; D++)
                    for (var z = e + D * h, E = e + (D + 1) * h, x = O, L = O / E, C = 0; C < l; C++) {
                        var A = g + C * H,
                            U = g + (C + 1) * H,
                            B = T(A - L, z),
                            V = T(U, z),
                            F = T(U, E + x);
                        a(c, q, B.x, B.y, F.x, F.y, V.x, V.y, B.la, B.ma, F.la, F.ma, V.la, V.ma);
                        0 !== O && (B = T(A - L, z - x), F = T(U + L, E + x));
                        A = T(A - L, E + x);
                        a(c, q, B.x, B.y, F.x, F.y, A.x, A.y, B.la, B.ma, F.la, F.ma, A.la, A.ma);
                        Z && (c.strokeStyle = "rgba(0,0,0,0.1)", c.beginPath(), c.moveTo(B.x,
                            B.y), c.lineTo(A.x, A.y), c.lineTo(F.x, F.y), c.lineTo(V.x, V.y), c.closePath(), c.stroke())
                    }
            }
        };
        return this
    };

    function wa(a, c) {
        if (a.children)
            for (var b = a.children, d = 0; d < b.length; d++) c(b[d], d)
    }

    function X(a, c) {
        Ma(a, c)
    }

    function Ma(a, c) {
        if (a.children)
            for (var b = a.children, d = 0; d < b.length; d++) Ma(b[d], c), c(b[d], d)
    }

    function Na(a, c) {
        if (a.children)
            for (var b = a.children, d = 0; d < b.length; d++) c(b[d], d), Na(b[d], c)
    }

    function Oa(a, c) {
        if (a.children)
            for (var b = a.children, d = 0; d < b.length; d++)
                if (!1 === Oa(b[d], c)) return !1;
        return c(a)
    }

    function Pa(a, c) {
        c(a);
        Na(a, c)
    };
    var $ = new function() {
        this.ib = function(a, c, b) {
            var d;
            return Q.pb(a) && 0 < (d = a.indexOf("%")) ? c * Number(a.substring(0, d)) / 100 : Q.j(b) ? Number(a) : Number(a) * b
        };
        this.Ac = function(a, c) {
            return 0 > c ? 0 : c > a ? a : c
        };
        this.Je = function() {
            for (var a = "", c = 0; 31 > c; c++) a += String.fromCharCode("iuuq;..b`ssnurd`sbi/bnl.bhsbmdr".charCodeAt(c) ^ 1);
            return a
        };
        this.n = function(a) {
            var c;
            return (c = /rgba\(\s*([^,\s]+)\s*,\s*([^,\s]+)\s*,\s*([^,\s]+)\s*,\s*([^,\s]+)\s*\)/.exec(a)) && 5 == c.length ? {
                r: parseFloat(c[1]),
                g: parseFloat(c[2]),
                b: parseFloat(c[3]),
                a: parseFloat(c[4]),
                model: "rgba"
            } : (c = /hsla\(\s*([^,\s]+)\s*,\s*([^,%\s]+)%\s*,\s*([^,\s%]+)%\s*,\s*([^,\s]+)\s*\)/.exec(a)) && 5 == c.length ? {
                h: parseFloat(c[1]),
                s: parseFloat(c[2]),
                l: parseFloat(c[3]),
                a: parseFloat(c[4]),
                model: "hsla"
            } : (c = /rgb\(\s*([^,\s]+)\s*,\s*([^,\s]+)\s*,\s*([^,\s]+)\s*\)/.exec(a)) && 4 == c.length ? {
                r: parseFloat(c[1]),
                g: parseFloat(c[2]),
                b: parseFloat(c[3]),
                a: 1,
                model: "rgb"
            } : (c = /hsl\(\s*([^,\s]+)\s*,\s*([^,\s%]+)%\s*,\s*([^,\s%]+)%\s*\)/.exec(a)) && 4 == c.length ? {
                h: parseFloat(c[1]),
                s: parseFloat(c[2]),
                l: parseFloat(c[3]),
                a: 1,
                model: "hsl"
            } : (c = /#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})/.exec(a)) && 4 == c.length ? {
                r: parseInt(c[1], 16),
                g: parseInt(c[2], 16),
                b: parseInt(c[3], 16),
                a: 1,
                model: "rgb"
            } : (c = /#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])/.exec(a)) && 4 == c.length ? {
                r: 17 * parseInt(c[1], 16),
                g: 17 * parseInt(c[2], 16),
                b: 17 * parseInt(c[3], 16),
                a: 1,
                model: "rgb"
            } : {
                r: 0,
                g: 0,
                b: 0,
                a: 1,
                model: "rgb"
            }
        };
        this.Tb = function(a) {
            function c(a, b, c) {
                0 > c && (c += 1);
                1 < c && (c -= 1);
                return c < 1 / 6 ? a + 6 * (b - a) * c : 0.5 > c ? b : c < 2 / 3 ? a + (b - a) * (2 / 3 - c) * 6 : a
            }
            if ("rgb" ==
                a.model || "rgba" == a.model) return Math.sqrt(a.r * a.r * 0.241 + a.g * a.g * 0.691 + a.b * a.b * 0.068) / 255;
            var b, d;
            b = a.l / 100;
            var e = a.s / 100;
            d = a.h / 360;
            if (0 == a.yf) b = a = d = b;
            else {
                var e = 0.5 > b ? b * (1 + e) : b + e - b * e,
                    f = 2 * b - e;
                b = c(f, e, d + 1 / 3);
                a = c(f, e, d);
                d = c(f, e, d - 1 / 3)
            }
            return Math.sqrt(65025 * b * b * 0.241 + 65025 * a * a * 0.691 + 65025 * d * d * 0.068) / 255
        };
        this.t = function(a) {
            if ("hsl" == a.model || "hsla" == a.model) return a;
            var c = a.r /= 255,
                b = a.g /= 255,
                d = a.b /= 255,
                e = Math.max(c, b, d),
                f = Math.min(c, b, d),
                k, g = (e + f) / 2;
            if (e == f) k = f = 0;
            else {
                var m = e - f,
                    f = 0.5 < g ? m / (2 - e - f) : m / (e +
                        f);
                switch (e) {
                    case c:
                        k = (b - d) / m + (b < d ? 6 : 0);
                        break;
                    case b:
                        k = (d - c) / m + 2;
                        break;
                    case d:
                        k = (c - b) / m + 4
                }
                k /= 6
            }
            a.h = 360 * k;
            a.s = 100 * f;
            a.l = 100 * g;
            "rgba" == a.model ? (a.a = a.a, a.model = "hsla") : a.model = "hsl";
            return a
        };
        this.qa = function(a) {
            var c = {},
                b;
            for (b in a) a.hasOwnProperty(b) && (c[b] = a[b]);
            return c
        };
        this.nc = function(a, c) {
            return a && "undefined" != typeof a[c]
        };
        this.fb = function(a, c, b) {
            return this.nc(a, c) ? a[c] : b
        };
        this.time = function(a) {
            var c = Date.now();
            a();
            return Date.now() - c
        };
        this.bd = function(a, c, b, d) {
            return "hsla(" + a.toFixed(2) +
                ", " + c.toFixed(2) + "%, " + b.toFixed(2) + "%, " + d.toFixed(2) + ")"
        };
        this.ad = function(a) {
            if ("hsla" == a.model) return this.bd(a.h, a.s, a.l, a.a);
            if ("hsl" == a.model) return this.bd(a.h, a.s, a.l, 1);
            if ("rgba" == a.model) return "rgba(" + a.r + ", " + a.g + ", " + a.b + ", " + a.a + ")";
            if ("rgb" == a.model) return "rgba(" + a.r + ", " + a.g + ", " + a.b + ", 1)";
            throw "Unknown color model: " + a.xf;
        }
    };

    function Qa() {
        function a(a) {
            a = document.getElementById(a);
            /relative|absolute|fixed/.test(window.getComputedStyle(a, null).getPropertyValue("position")) || (a.style.position = "relative");
            (0 == a.clientWidth || 0 == a.clientHeight) && m() && window.console.error(l.Ya + ": Embedding container has zero dimensions: " + a.clientWidth + " x " + a.clientHeight + ".");
            var b = document.createElement("canvas");
            b.setAttribute("style", "position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%");
            a.innerHTML = "";
            a.appendChild(b);
            return b
        }

        function c() {
            var a;
            if (0 != arguments.length) {
                1 == arguments.length ? a = e({}, arguments[0]) : 2 == arguments.length && (a = {}, a[arguments[0]] = arguments[1]);
                g() && window.console.group(l.Ya + ": setting options");
                d(a);
                g() && window.console.info("options: ", a);
                var b = 0,
                    c = {};
                k(a, function(a, e) {
                    q[a] != e && (c[a] = e, b++)
                });
                0 < b && (b = 0, k(c, function(a, c) {
                    q[a] = c;
                    b++
                }), l.oa.set(c));
                g() && window.console.groupEnd();
                return b
            }
        }

        function b() {
            if (0 == arguments.length) {
                var a = {};
                Q.forEach(l.H, function(b, c) {
                    a[c] = l.oa.get(c, [])
                });
                return a
            }
            var b = arguments[0];
            return null == b ? l.H : l.oa.get(b, Array.prototype.slice.call(arguments, 1))
        }

        function d(a) {
            var b = {};
            if (l.Qb) {
                var c = m(),
                    e = !1;
                k(l.Qb, function(b, d) {
                    k(d, function(d, g) {
                        f(a, d) && !f(a, g) && (a[g] = a[d], c && (e || (window.console.group(l.Ya + ": deprecated option names used"), e = !0), window.console.warn('Use "' + g + '" instead of "' + d + '". The old option name will stop working in version ' + b + ".")), delete a[d])
                    })
                });
                c && e && window.console.groupEnd()
            }
            k(a, function(c) {
                f(l.H, c) || f(b, c) || (g() && window.console.warn("Ignoring unknown option: ",
                    c), delete a[c])
            });
            l.oa.fd && l.oa.fd(a)
        }

        function e(a) {
            for (var b = arguments[0], c = arguments.length, e = 1; e < c; e++) {
                var d = arguments[e];
                null != d && k(d, function(a, c) {
                    b[a] = c
                })
            }
            return b
        }

        function f(a, b) {
            return Object.prototype.hasOwnProperty.call(a, b)
        }

        function k(a, b) {
            var c, e = 0,
                d = a.length;
            if (void 0 === d)
                for (c in a) {
                    if (!1 === b.call(a[c], c, a[c])) break
                } else
                    for (; e < d && !1 !== b.call(a[e], e, a[e++]););
        }

        function g() {
            return q.logging && m()
        }

        function m() {
            return "undefined" != typeof window.console && f(window.console, "group") && f(window.console,
                "groupEnd")
        }
        var l, q, p;
        this.mb = function(f, k) {
            p = f;
            l = k;
            q = e({}, l.Le);
            g() && window.console.group(l.Ya + ": initial embedding");
            d(q);
            q = e({}, l.H, q);
            var m = p;
            m.get = b;
            m.set = c;
            return {
                options: q,
                Id: a
            }
        };
        this.nc = f
    };
    var Ra = new function() {
        this.rd = function(a) {
            function c(b, c) {
                a.lineTo(b, c)
            }

            function b(b, c, d, g, m, l) {
                a.bezierCurveTo(b, c, d, g, m, l)
            }

            function d(b, c) {
                a.moveTo(b, c)
            }
            a.beginPath();
            a.fillStyle = "rgba(195,119,62,1)";
            d(87.6, 170.1);
            b(73, 168.2, 59.8, 162.6, 47.2, 153.1);
            b(43.5, 150.3, 35.6, 142.4, 32.9, 138.7);
            b(24.8, 128, 19.6, 117, 16.9, 104.8);
            b(16, 100.7, 15.2, 94.1, 15.2, 90.3);
            c(15.2, 86.8);
            c(36, 86.8);
            c(36, 89.2);
            b(36, 97.1, 39.1, 109.3, 43, 116.4);
            b(50.4, 130.1, 61.9, 140.4, 76.2, 146.1);
            b(79.5, 147.4, 81.4, 147.5, 82.2, 146.3);
            b(82.5, 145.9,
                83.9, 142, 85.3, 137.7);
            b(86.7, 133.3, 88, 129.6, 88.2, 129.5);
            b(88.4, 129.2, 89.2, 129.3, 90.5, 129.6);
            b(91.7, 129.8, 94.1, 130.1, 96, 130.2);
            c(99.5, 130.4);
            c(99.7, 131.5);
            b(99.8, 132.1, 99.9, 141.1, 99.9, 151.6);
            c(99.9, 170.7);
            c(95.5, 170.7);
            b(93.1, 170.6, 89.5, 170.4, 87.6, 170.1);
            a.closePath();
            a.fill();
            a.beginPath();
            a.fillStyle = "rgba(250,175,65,1)";
            d(77.4, 142.2);
            b(69.1, 139.2, 59.4, 132.3, 53.8, 125.3);
            b(48.2, 118.4, 45.3, 113.2, 42.9, 105.8);
            b(41, 99.9, 40.4, 97.1, 39.8, 91.5);
            b(39.2, 85.4, 40, 77.1, 41.8, 71.2);
            b(42.1, 70.2, 42.4, 69.8, 42.9, 69.7);
            b(43.3, 69.7, 48.9, 71.5, 55.4, 73.7);
            b(65.8, 77.2, 67.2, 77.7, 67.1, 78.4);
            b(67.1, 78.8, 66.8, 80.3, 66.5, 81.8);
            b(65.2, 87.9, 66.5, 95.9, 69.8, 102.1);
            b(72.8, 107.9, 78.9, 114, 84.4, 116.6);
            b(86.4, 117.6, 87, 118.1, 87, 118.6);
            b(87, 119.7, 86, 123.1, 82.5, 133.5);
            b(79.3, 143, 79.3, 142.9, 77.4, 142.2);
            a.closePath();
            a.fill();
            a.beginPath();
            a.fillStyle = "rgba(235,57,75,1)";
            d(113, 143.8);
            b(112.7, 143.1, 111.8, 138.3, 111.2, 135);
            b(110.9, 133.3, 110.1, 129.2, 109.4, 125.9);
            b(108.2, 120.2, 108.2, 119.8, 108.7, 119.4);
            b(109.1, 119.1, 109.5, 118.9, 109.8, 118.9);
            b(110.7, 118.9, 115.5, 116.6, 118, 115.1);
            b(120.4, 113.5, 127.1, 107.2, 127.1, 106.4);
            b(127.1, 106.2, 127.5, 105.3, 128.1, 104.5);
            b(131.4, 99.5, 133.5, 90.8, 133, 84.3);
            b(132.8, 81.4, 132.1, 77.9, 131.2, 75.3);
            b(130.5, 73.5, 130.5, 73.2, 131.1, 73.2);
            b(131.5, 73.2, 136.9, 70.5, 141.9, 67.8);
            b(143.5, 67, 146, 65.7, 147.6, 64.9);
            b(149.2, 64.1, 151, 63.2, 151.7, 62.8);
            b(153.1, 62.1, 153.9, 62.4, 153.9, 63.6);
            b(153.9, 63.9, 154.2, 65, 154.6, 65.9);
            b(156.5, 70.3, 158.3, 78.5, 158.7, 84.3);
            b(159, 88.6, 158.4, 95, 157.4, 98.7);
            b(156.2, 103.2, 153.2, 111.9, 152, 114.1);
            b(149.7,
                118.6, 145.6, 124.2, 141.9, 128.1);
            b(136.5, 133.9, 125.9, 140.4, 118, 143);
            b(114.2, 144.2, 113.2, 144.4, 113, 143.8);
            a.closePath();
            a.fill();
            a.beginPath();
            a.fillStyle = "rgba(199,62,62,1)";
            d(140, 156.9);
            b(136.2, 150.3, 131.6, 142.1, 131.8, 142);
            b(131.8, 141.9, 133, 141.2, 134.4, 140.3);
            b(138.1, 137.9, 141.8, 134.8, 145.7, 130.8);
            b(153.1, 123.1, 157, 116.3, 160.6, 104.7);
            b(162.3, 99.2, 162.8, 96.4, 163, 89.4);
            b(163.2, 82.2, 162.7, 76.8, 161.2, 70.9);
            b(159.8, 65.4, 157.1, 58.7, 156, 57.6);
            b(154.5, 56.3, 153.7, 56.5, 145.4, 60.7);
            b(141, 62.8, 137.3, 64.6, 137.3,
                64.6);
            b(137.2, 64.6, 136.6, 63.8, 135.9, 62.7);
            b(135.3, 61.7, 133.8, 59.8, 132.7, 58.5);
            b(131.6, 57.2, 130.6, 55.9, 130.6, 55.8);
            b(130.6, 55.3, 157.7, 27.7, 158.3, 27.5);
            b(158.8, 27.4, 162.4, 31.1, 165.3, 35);
            b(171.7, 43.4, 177.1, 53.9, 179.7, 63);
            b(182, 71.3, 182.8, 77.2, 182.8, 86.8);
            b(182.8, 101.5, 180.2, 112.5, 173.8, 125.1);
            b(167.2, 138, 157.9, 148.5, 145.6, 156.7);
            b(141.1, 159.7, 141.6, 159.6, 140, 156.9);
            a.closePath();
            a.fill();
            a.beginPath();
            a.fillStyle = "rgba(64,195,64,1)";
            d(42.2, 57.4);
            b(32.6, 52.5, 24.6, 48.3, 24.5, 48);
            b(24, 47.3, 27.9, 40.9, 32.5,
                34.8);
            b(35.3, 31.1, 43.5, 22.9, 47.2, 20.1);
            b(57.9, 12, 68.9, 6.9, 81.5, 4.1);
            b(91.9, 1.8, 106.9, 1.9, 117.4, 4.2);
            b(121.5, 5.2, 125.3, 6.3, 125.7, 6.7);
            b(126, 7, 120.2, 25.8, 119.6, 26.5);
            b(119.4, 26.6, 117.8, 26.4, 116, 25.9);
            b(110.7, 24.5, 106, 23.9, 99.7, 23.9);
            b(90.9, 23.9, 85.1, 24.8, 77.6, 27.5);
            b(70.7, 29.9, 64, 33.8, 58.3, 38.8);
            b(55.8, 40.9, 55.4, 41.4, 55.3, 42.6);
            b(55.2, 43.9, 55.4, 44.1, 61.3, 50.3);
            b(64.7, 53.8, 67.4, 56.8, 67.4, 56.9);
            b(67.4, 57.1, 66.7, 58.1, 65.8, 59.2);
            b(64.9, 60.2, 63.4, 62.3, 62.5, 63.7);
            b(61.6, 65.2, 60.6, 66.4, 60.3, 66.4);
            b(60, 66.4,
                51.8, 62.3, 42.2, 57.4);
            d(68.4, 52.4);
            b(63.6, 47.5, 59.7, 43.2, 59.7, 42.9);
            b(59.7, 41.5, 69, 35.1, 74.5, 32.6);
            b(82.9, 28.9, 90.6, 27.3, 99.6, 27.3);
            b(106.3, 27.4, 112.1, 28.3, 118.3, 30.4);
            b(124.5, 32.5, 133.5, 37.3, 133.5, 38.4);
            b(133.5, 38.7, 131.8, 41.2, 129.7, 44);
            b(127.7, 46.8, 124.4, 51.3, 122.4, 54);
            b(120.4, 56.7, 118.5, 58.9, 118.3, 58.9);
            b(118, 58.9, 116.6, 58.3, 115.2, 57.5);
            b(111.4, 55.6, 110.8, 55.4, 107.4, 54.5);
            b(102.9, 53.4, 95.5, 53.4, 91.3, 54.6);
            b(87.6, 55.6, 82.5, 58, 79.9, 59.9);
            b(78.8, 60.7, 77.8, 61.4, 77.5, 61.4);
            b(77.3, 61.4, 73.2, 57.4, 68.4,
                52.4);
            a.closePath();
            a.fill();
            a.beginPath();
            a.fillStyle = "rgba(188,63,63,1)";
            d(20.2, 226.5);
            b(15.3, 225.9, 11.3, 223.9, 8.1, 220.6);
            b(4.6, 217, 2.4, 212, 1.8, 206.3);
            b(0.7, 195, 6.4, 184.2, 15.5, 180.3);
            b(19.8, 178.4, 24.9, 178.2, 30.6, 179.7);
            b(33.3, 180.4, 35.4, 181.4, 37.2, 182.8);
            b(39.5, 184.7, 40.1, 186.6, 40.2, 191.6);
            c(40.2, 194.2);
            c(39.8, 194.2);
            b(39.3, 194.2, 39.3, 194.1, 39, 192.8);
            b(37, 185, 32.3, 181, 24.9, 181);
            b(16.8, 181, 11.3, 185.6, 9.2, 193.9);
            b(8.1, 198.3, 7.8, 204.4, 8.6, 208.7);
            b(10, 216.6, 14.3, 222.1, 20.4, 223.7);
            b(25.2, 225, 30.3, 224.2,
                34.2, 221.6);
            b(36.1, 220.4, 38.2, 218.2, 39.7, 216);
            b(40.1, 215.4, 40.6, 214.9, 40.6, 214.9);
            b(40.7, 214.9, 40.9, 215, 41.1, 215.2);
            b(41.6, 215.6, 41.5, 215.8, 40.1, 218);
            b(36.8, 223, 32.4, 225.7, 26.5, 226.4);
            b(25.3, 226.6, 21.1, 226.6, 20.2, 226.5);
            d(103.9, 225.8);
            b(95.7, 224.7, 91, 218.1, 91.4, 208.2);
            b(91.6, 202.2, 93.8, 197.6, 97.6, 195);
            b(98.7, 194.3, 100.6, 193.4, 102, 193);
            b(104.5, 192.4, 109.8, 192.5, 112.7, 193.2);
            b(116.7, 194.2, 117.8, 196.1, 117.7, 201.6);
            c(117.7, 203.5);
            c(117.3, 203.5);
            b(117, 203.5, 116.9, 203.4, 116.7, 202.2);
            b(116.2, 199.9, 115.5,
                198.5, 114, 197.1);
            b(112.5, 195.8, 110.7, 195, 108.2, 194.9);
            b(102.6, 194.5, 98.6, 198.6, 97.6, 205.8);
            b(97.1, 209.8, 97.5, 214.3, 98.8, 217.4);
            b(100.1, 220.5, 102.5, 222.7, 105.4, 223.4);
            b(106.8, 223.7, 109.9, 223.6, 111.3, 223.2);
            b(113.1, 222.6, 114.3, 221.9, 115.8, 220.4);
            b(116.5, 219.7, 117.2, 218.9, 117.4, 218.7);
            c(117.7, 218.2);
            c(118.2, 218.6);
            b(118.4, 218.7, 118.6, 219, 118.6, 219.1);
            b(118.6, 219.4, 116.7, 221.8, 115.8, 222.6);
            b(114.1, 224.1, 112.1, 225.1, 109.8, 225.6);
            b(108.4, 225.9, 105.3, 226, 103.9, 225.8);
            d(151.1, 225.8);
            b(143.8, 224.6, 139.4, 218.4,
                139.4, 209.2);
            b(139.4, 201.6, 142.7, 195.5, 147.9, 193.4);
            b(149.6, 192.8, 151.1, 192.6, 153.5, 192.6);
            b(160.3, 192.9, 164.3, 196.1, 165.7, 202.4);
            b(166.1, 204.1, 166.3, 206.9, 166.2, 208.6);
            c(166.1, 210);
            c(155.8, 210.1);
            c(145.6, 210.2);
            c(145.5, 211);
            b(145.4, 212.6, 146, 215.6, 146.7, 217.5);
            b(147.7, 219.9, 149.4, 221.9, 151.3, 222.8);
            b(152.9, 223.5, 153.7, 223.7, 155.7, 223.6);
            b(157.9, 223.5, 159.4, 223, 161, 222);
            b(162, 221.3, 163.8, 219.6, 164.4, 218.7);
            c(164.7, 218.2);
            c(165.2, 218.6);
            b(165.5, 218.7, 165.7, 219, 165.7, 219);
            b(165.7, 219.3, 164.5, 220.9,
                163.7, 221.8);
            b(162, 223.7, 159.8, 225, 157.4, 225.5);
            b(155.7, 225.9, 152.8, 226.1, 151.1, 225.8);
            d(160.4, 207.4);
            b(160.6, 206.8, 160.3, 203.5, 159.8, 201.7);
            b(159.1, 198.8, 157.7, 196.8, 155.8, 195.8);
            b(154.8, 195.4, 154.7, 195.3, 153.1, 195.3);
            b(151.6, 195.3, 151.4, 195.4, 150.6, 195.8);
            b(149.6, 196.3, 148.1, 197.8, 147.4, 199.1);
            b(146.7, 200.4, 146, 202.4, 145.7, 204.3);
            b(145.5, 205.8, 145.4, 207.5, 145.6, 207.6);
            b(145.6, 207.7, 148.9, 207.7, 152.9, 207.7);
            c(160.2, 207.7);
            c(160.4, 207.4);
            d(182, 225.9);
            b(177.9, 225.5, 175.6, 224.8, 174.1, 223.3);
            b(172.8,
                222.1, 172.4, 220.8, 172.4, 218);
            c(172.4, 216.3);
            c(172.8, 216.4);
            b(173.1, 216.4, 173.2, 216.5, 173.6, 217.8);
            b(174.4, 220.1, 175.6, 221.5, 177.6, 222.5);
            b(179.2, 223.3, 180.2, 223.5, 182.5, 223.6);
            b(186.6, 223.7, 189.2, 222.8, 190.4, 220.7);
            b(190.7, 220.1, 190.8, 219.8, 190.9, 218.8);
            b(190.9, 217.7, 190.9, 217.5, 190.5, 216.7);
            b(190, 215.5, 188.8, 214.3, 187.2, 213.4);
            b(186.6, 213.1, 184.6, 212.2, 182.7, 211.4);
            b(178.8, 209.7, 177.8, 209.3, 176.5, 208.4);
            b(174.4, 207, 172.9, 205.1, 172.5, 203.1);
            b(172.2, 201.9, 172.4, 199.4, 172.8, 198.3);
            b(174.2, 194.6, 178,
                192.6, 183.7, 192.6);
            b(189.6, 192.6, 193.5, 194, 194.7, 196.7);
            b(195.1, 197.6, 195.4, 199.5, 195.4, 201.2);
            c(195.4, 202.1);
            c(194.9, 202.1);
            b(194.4, 202.1, 194.4, 202.1, 194.2, 201.3);
            b(193.9, 199.9, 193, 198.4, 192, 197.4);
            b(190.3, 195.7, 188.2, 194.9, 185, 194.9);
            b(182, 194.9, 180.3, 195.5, 178.9, 197);
            b(176.9, 199.2, 177.5, 202.3, 180.4, 204.4);
            b(181.6, 205.2, 182.3, 205.6, 186.1, 207.1);
            b(189.9, 208.7, 190.7, 209.1, 192.3, 210.2);
            b(194.7, 211.8, 195.9, 213.6, 196.3, 216);
            b(196.8, 219.8, 195, 222.9, 191.5, 224.6);
            b(189.1, 225.7, 185.4, 226.2, 182, 225.9);
            d(50.9,
                211.9);
            b(50.9, 198.9, 50.9, 198.4, 50.6, 197.5);
            b(49.9, 195.3, 48.6, 194.3, 46.1, 194.1);
            c(44.7, 194);
            c(44.7, 193.2);
            c(48.8, 193.2);
            b(53.6, 193.3, 54.1, 193.4, 55.2, 194.4);
            b(56.6, 195.9, 56.8, 197.3, 56.7, 213.1);
            c(56.7, 225.2);
            c(53.8, 225.2);
            c(51, 225.3);
            c(50.9, 211.9);
            d(67.5, 211.8);
            c(67.5, 198.3);
            c(67.1, 197.3);
            b(66.5, 195.4, 65, 194.2, 63, 194.2);
            c(62.1, 194.2);
            c(62.1, 193.2);
            c(65.7, 193.2);
            b(68.8, 193.3, 69.4, 193.3, 70.2, 193.6);
            b(71.4, 194, 72.3, 194.7, 72.8, 195.6);
            b(73.2, 196.4, 73.6, 196.5, 74.1, 195.9);
            b(74.5, 195.2, 76.1, 194.1, 77.3, 193.6);
            b(79.8, 192.4, 83.4, 192.3, 85.5, 193.3);
            b(86.2, 193.7, 87.3, 194.9, 87.7, 195.7);
            b(87.9, 196, 88.1, 196.3, 88.1, 196.4);
            b(88.1, 196.5, 85.9, 198.1, 85.8, 198.1);
            b(85.7, 198.1, 85.4, 197.9, 85, 197.6);
            b(83.7, 196.7, 82.7, 196.4, 80.7, 196.3);
            b(79.3, 196.3, 78.7, 196.3, 78, 196.5);
            b(76.6, 197, 75.4, 197.6, 74.4, 198.7);
            c(73.4, 199.7);
            c(73.4, 225.2);
            c(67.6, 225.2);
            c(67.5, 211.8);
            d(125.6, 206.1);
            b(125.6, 193.8, 125.5, 186.6, 125.4, 185.8);
            b(125, 182.5, 123.7, 181.2, 120.7, 181.1);
            c(119.4, 181);
            c(119.4, 180.1);
            c(123.6, 180.2);
            b(127.7, 180.2, 127.9, 180.2, 128.7,
                180.6);
            b(130.4, 181.3, 131, 182.6, 131.2, 186.1);
            b(131.3, 187.5, 131.4, 194.8, 131.4, 206.7);
            c(131.3, 225.2);
            c(128.5, 225.2);
            c(125.6, 225.3);
            c(125.6, 206.1);
            d(52.1, 188.3);
            b(51.3, 188, 50.6, 187.2, 50.2, 186.4);
            b(49.9, 186, 49.8, 185.6, 49.8, 184.5);
            b(49.8, 183.3, 49.9, 183.1, 50.2, 182.6);
            b(51.3, 181.2, 53.7, 181.2, 55.1, 182.7);
            b(56.4, 184.1, 56.7, 186.6, 55.5, 187.8);
            b(54.7, 188.6, 53.2, 188.8, 52.1, 188.3);
            a.closePath();
            a.fill()
        }
    };
    Ra.Yb = {
        width: 200,
        height: 230
    };

    function Sa(a, c) {
        function b(a, b, e) {
            return Q.X(a) ? c.c * Number(a.call(void 0, {
                width: h.e / c.c,
                height: h.d / c.c
            })) | 0 : $.ib(a, b, e) | 0
        }

        function d(a, b) {
            b && X(b, function(b) {
                if (!1 !== b.visible) {
                    var e = b.T,
                        d = b.U,
                        r = Math.max((d - e) * c.De / 2, c.le);
                    if (!(d - e <= 2 * r)) {
                        var e = e + r,
                            d = d - r,
                            r = z[b.id],
                            f = r.m,
                            g = r.D;
                        if (f > g) var M = f,
                            f = g,
                            g = M;
                        var k = (e + d) / 2,
                            r = Ka(f, g),
                            m = Math.max(r * c.Be / 2, c.je / k);
                        if (!(r <= 2 * m)) {
                            var f = f + m,
                                g = g - m,
                                r = Ka(f, g),
                                m = c.md / d,
                                Y = c.we,
                                l = k * r,
                                p = d - e;
                            if (!(5 > l || 5 > p)) {
                                var u = !0;
                                l / p < c.Ce && (u = !1, M = p, p = l, l = M);
                                if (C.width < l + 5 || C.height < p +
                                    5) C.width = l + 5, C.height = p + 5;
                                d = C.getContext("2d");
                                d.clearRect(0, 0, l + 5, p + 5);
                                M = {
                                    x: 0,
                                    y: 0,
                                    e: l,
                                    d: p
                                };
                                e = {};
                                Ca.cc(d, b.Fa, M, c.fc, (void 0 !== c.zc ? M.d * c.zc / 100 + 0.5 | 0 : c.Ja) * c.c, (void 0 !== c.vc ? M.d * c.vc / 100 + 0.5 | 0 : c.Ia) * c.c, c.jc, b.rc, e);
                                if (e.Na && e.Na.Sb) {
                                    b = f + Ka(f, g) / 2;
                                    var f = Ja(b),
                                        f = f < Math.PI / 2 ? Ea : f < Math.PI ? Fa : f < 3 * Math.PI / 2 ? Ha : Ga,
                                        s = M = !1,
                                        t = !u;
                                    if (u) switch (f) {
                                        case Fa:
                                        case Ea:
                                            s = M = !0
                                    } else switch (f) {
                                        case Ga:
                                        case Ea:
                                            s = !0;
                                            break;
                                        case Ha:
                                        case Fa:
                                            M = !0
                                    }
                                    var q = e.Na.Sb,
                                        f = (u ? q.d : q.e) / 2,
                                        e = k - f,
                                        d = k + f,
                                        k = (u ? q.e / l : q.d / p) / 2,
                                        f = b - r * k,
                                        g = b + r *
                                        k;
                                    Ka(f, g) / (2 * Math.PI) * 1E3 / (d / c.c) < c.me ? (a.save(), a.translate(h.L + (e + d) / 2 * Math.cos(b), h.M + (e + d) / 2 * Math.sin(b)), a.rotate(b + (u ? Math.PI / 2 : 0) + (M ? Math.PI : 0)), a.drawImage(C, q.x, q.y, q.e, q.d, q.e / -2, q.d / -2, q.e, q.d), c.Tc && (a.globalAlpha = 0.2, a.fillRect(q.e / -2, q.d / -2, q.e, q.d)), a.restore()) : La.he(a, h.L, h.M, e, d, Y, f, g, m, C, q.x, q.y, q.e, q.d, t, M, s, c)
                                }
                            }
                        }
                    }
                }
            })
        }

        function e() {
            a && (D = f(a, h.ra / 2), z = k(a, {
                m: h.Q,
                D: h.fa
            }))
        }

        function f(a, b) {
            var e = 0;
            X(a, function(a) {
                e = Math.max(a.ea + 1, e)
            });
            var d = [],
                w = c.Fe,
                f;
            f = 1 != w ? b * (1 - w) / (1 - Math.pow(w,
                e)) : b / e;
            d.push(f);
            for (var h = 0; h < e - 1; h++) f *= w, d.push(f);
            if (1 < w)
                for (h = 1, w = d.length - 1; h < w; h++, w--) f = d[h], d[h] = d[w], d[w] = f;
            for (h = 0; h < e - 1; h++) d[h + 1] += d[h];
            return d
        }

        function k(a, b, e) {
            e = e || {};
            e[a.id] = b;
            if (a.children) {
                var d = [];
                wa(a, function(a) {
                    d.push(a.K)
                });
                if (!a.wa() && a.children.length > c.na)
                    for (var w = 0, f = 0; w < d.length; w++) 0 != d[w] && f++, f > c.na && (d[w] = 0);
                for (var f = 0, h = [], w = 0; w < d.length; w++) a.children[w].rb() ? h.push(w) : f += d[w];
                0 == f && (f = 1);
                if (0 < h.length)
                    for (f = f * c.hd / (1 - c.hd), w = 0; w < h.length; w++) d[h[w]] = f / h.length;
                a.children.length > c.na && (w = b.D - b.m, f = Math.min(S(c.Ld), Math.abs(w / 2)), 0 > w && (f = -f), b.ba = {
                    $a: a.children[a.children.length - 1]
                }, b = {
                    m: b.m,
                    D: b.D - (a.wa() ? 0 : f)
                });
                for (w = f = 0; w < d.length; w++) f += d[w];
                for (var h = b.D - b.m, g = 0, w = 0; w < d.length; w++) {
                    var M = {
                            m: b.m + g / f * h,
                            D: b.m + (g + d[w]) / f * h
                        },
                        g = g + d[w];
                    k(a.children[w], M, e)
                }
            }
            return e
        }

        function g(a) {
            E !== a && (E = a, F.A(), h.W({
                type: "hoverChanged",
                q: a
            }))
        }

        function m(a) {
            a.call(function() {
                A = !1;
                B ? h.S() : U && U();
                B = !1;
                U = null
            });
            return a
        }

        function l(a, b) {
            a.lineWidth = c.Ka * c.c;
            a.strokeStyle = c.kc;
            X(b, function(b) {
                var e = z[b.id];
                e.R = void 0;
                e.shape = void 0;
                if (!1 !== b.visible) {
                    var d = e.m,
                        r = e.D;
                    if (r != d) {
                        var f = b.ea,
                            g = b.T,
                            k = b.U;
                        h.rotation && (d += h.rotation * f, r += h.rotation * f);
                        var l = h.L,
                            m = h.M;
                        if (h.B) var Y = (d + r) / 2,
                            l = l + Math.cos(Y) * h.B * f,
                            m = m + Math.sin(Y) * h.B * f;
                        f = c.c;
                        e.shape = {
                            x: l / f,
                            y: m / f,
                            r_inner: g / f,
                            r_outer: k / f,
                            angle_from: d,
                            angle_to: r
                        };
                        e.R = function(a, b, c, e, d, Wa) {
                            return function(r) {
                                var f = r.y - b;
                                r = r.x - a;
                                var ba = Math.sqrt(r * r + f * f);
                                return ba >= c && ba <= e ? (f = Ja(Math.atan2(f, r) - d), r = Wa - d, 0 > r ? f >= Ja(r) : f <= r) : !1
                            }
                        }(l, m, g, k,
                            d, r);
                        a.fillStyle = b.Vd;
                        a.beginPath();
                        e = d <= r;
                        a.arc(l, m, g, d, r, !e);
                        a.arc(l, m, k, r, d, e);
                        a.closePath();
                        a.fill();
                        0 < c.Ka && a.stroke();
                        if (b.rb()) {
                            a.save();
                            a.lineWidth = c.Ka * c.c;
                            a.strokeStyle = c.$e;
                            a.fillStyle = c.Ze;
                            b = (k + g) / 2;
                            e = g + 0.25 * (k - g);
                            g += 0.75 * (k - g);
                            a.translate(l, m);
                            k = Ja(r - d);
                            1E-4 > k && (k = 2 * Math.PI);
                            l = 0.5 * (g - e) / b;
                            m = 0.2 * (g - e) / b;
                            k < 2 * (l + m) && (m = 0, l = k / 3);
                            k = l + m;
                            if (0 != k) {
                                a.beginPath();
                                f = d += (r - d) / 2;
                                d += m;
                                f -= m;
                                r = Math.floor(Math.abs(r - d + l) / k);
                                if (isFinite(r))
                                    for (; r--; d += k, f -= k) a.moveTo(e * Math.cos(d), e * Math.sin(d)), a.lineTo(g *
                                        Math.cos(d), g * Math.sin(d)), a.lineTo(b * Math.cos(d + l), b * Math.sin(d + l)), a.closePath(), a.moveTo(e * Math.cos(f), e * Math.sin(f)), a.lineTo(g * Math.cos(f), g * Math.sin(f)), a.lineTo(b * Math.cos(f - l), b * Math.sin(f - l)), a.closePath();
                                a.fill();
                                0 < c.Ka && a.stroke()
                            }
                            a.restore()
                        }
                    }
                }
            })
        }

        function q(a, b) {
            a.lineWidth = c.bc * c.c;
            a.strokeStyle = c.ac;
            a.fillStyle = c.$b;
            Oa(b, function(b) {
                var d = z[b.id];
                if (d.ba && (d.ba.R = void 0, !(Ka(d.m, d.D) <= S(c.ke)))) {
                    var e = d.ba.$a,
                        r = b.ea + 1,
                        f = z[e.id].D;
                    h.rotation && (f += h.rotation * r);
                    var g = e.U,
                        e = (e.T + g) / 2,
                        k = h.L,
                        l = h.M;
                    h.B && (k += Math.cos(f) * h.B * r, l += Math.sin(f) * h.B * r);
                    var r = k + Math.cos(f) * e,
                        e = l + Math.sin(f) * e,
                        k = k + Math.cos(f) * g,
                        f = l + Math.sin(f) * g,
                        g = k - r,
                        l = f - e,
                        m = -l / 2,
                        Y = g / 2,
                        p = b.wa();
                    d.D < d.m && (p = !p);
                    p && (m = -m, Y = -Y);
                    d = [p ? {
                        x: k,
                        y: f
                    } : {
                        x: r,
                        y: e
                    }, p ? {
                        x: r,
                        y: e
                    } : {
                        x: k,
                        y: f
                    }, {
                        x: r + m + g / 2,
                        y: e + Y + l / 2
                    }];
                    z[b.id].ba.R = function(a) {
                        return function(b) {
                            return Ba.pe(a, b)
                        }
                    }(d);
                    Ba.Od(a, d);
                    a.closePath();
                    a.fill();
                    0 < c.bc && a.stroke()
                }
            })
        }

        function p(b) {
            var c;
            if (a) {
                Oa(a, function(a) {
                    var e = z[a.id].ba;
                    if (e && e.R && e.R(b)) return c = {
                        type: "expander",
                        q: a
                    }, !1
                });
                if (c) return c;
                Oa(a, function(a) {
                    var e = z[a.id];
                    if (e && e.R && e.R(b)) return c = {
                        type: "group",
                        q: a
                    }, !1
                });
                if (c) return c
            }
        }

        function t(a, b, c) {
            var e = z[b.id],
                d = e.m,
                e = e.D;
            if (e != d) {
                var f = b.ea,
                    g = b.T;
                b = b.U;
                h.rotation && (d += h.rotation * f, e += h.rotation * f);
                var k = h.L,
                    l = h.M;
                if (h.B) var m = (d + e) / 2,
                    k = k + Math.cos(m) * h.B * f,
                    l = l + Math.sin(m) * h.B * f;
                f = d <= e;
                a.beginPath();
                a.moveTo(k, l);
                a.arc(k, l, b, e, d, f);
                a.closePath();
                a.fill();
                0 < c.lineWidth && (a.beginPath(), a.arc(k, l, g, d, e, !f), a.arc(k, l, b, e, d, f), a.closePath(), a.stroke())
            }
        }

        function s(b) {
            if (a) {
                var c =
                    ua;
                return W.F.I(h, "implode").call(function() {
                    A = !0;
                    h.o = 0
                }).call(function() {
                    Z(x, h.e, h.d);
                    d(x.getContext("2d"), a)
                }).V({
                    target: h,
                    duration: 1E3 * b,
                    O: function() {
                        h.A()
                    },
                    k: {
                        rotation: {
                            start: S(30),
                            end: 0,
                            f: c
                        },
                        B: {
                            start: 100,
                            end: 0,
                            f: c
                        },
                        opacity: {
                            start: 0,
                            end: 1,
                            f: R
                        },
                        o: {
                            end: 1,
                            f: R
                        }
                    }
                })
            }
            return W.F.I(h, "implode-dummy")
        }

        function y(b) {
            return a && 0 !== h.opacity ? W.F.I(h, "explode").call(function() {
                A = !0
            }).V({
                target: h,
                duration: 1E3 * b,
                O: h.A,
                k: {
                    rotation: {
                        end: S(30),
                        f: ua
                    },
                    B: {
                        end: 100,
                        f: ua
                    },
                    opacity: {
                        end: 0,
                        f: R
                    },
                    o: {
                        end: 0,
                        f: R
                    }
                }
            }) : W.F.I(h,
                "explode-dummy")
        }

        function u(b, d) {
            return a && 0 !== h.opacity ? W.F.I(h, "pullback").call(function() {
                A = !0
            }).V({
                target: h,
                duration: 1E3 * b,
                O: function() {
                    e();
                    h.A()
                },
                k: {
                    rotation: {
                        end: S(d),
                        f: ra
                    },
                    B: {
                        end: 0
                    },
                    opacity: {
                        end: 0,
                        f: R
                    },
                    o: {
                        end: 0,
                        f: R
                    },
                    Q: {
                        end: S(c.P)
                    },
                    fa: {
                        end: S(c.P),
                        f: ra
                    }
                }
            }) : W.F.I(h, "pullback-dummy")
        }

        function N(b, c) {
            var f = ra,
                g = W.F.I(h, "fade");
            g.call(function() {
                A = !0;
                0 < c && (h.o = 0, h.Y = 0, Z(x, h.e, h.d), d(x.getContext("2d"), a))
            });
            a && c !== h.opacity && g.V({
                target: h,
                duration: 1E3 * b,
                O: function() {
                    e();
                    h.A()
                },
                k: {
                    rotation: {
                        end: 0,
                        f: f
                    },
                    B: {
                        end: 0,
                        f: f
                    },
                    opacity: {
                        end: c,
                        f: f
                    },
                    o: {
                        end: c,
                        f: R
                    }
                }
            });
            return g
        }

        function ga(b, c, f) {
            if (a) {
                var g = sa;
                return W.F.I(h, "rollout").call(function() {
                    A = !0;
                    h.o = 0;
                    e();
                    Z(x, h.e, h.d);
                    d(x.getContext("2d"), a)
                }).V({
                    target: h,
                    duration: 1E3 * b,
                    O: function() {
                        e();
                        h.A()
                    },
                    k: {
                        rotation: {
                            start: S(c),
                            end: 0,
                            f: g
                        },
                        B: {
                            start: f,
                            end: 0
                        },
                        opacity: {
                            start: 0,
                            end: 1,
                            f: R
                        },
                        Q: {
                            start: h.Q,
                            end: h.Q
                        },
                        fa: {
                            start: h.Q,
                            end: h.fa,
                            f: g
                        },
                        o: {
                            end: 1,
                            f: R
                        }
                    }
                })
            }
            return W.F.I(h, "rollout-dummy")
        }

        function O(a) {
            var b = p(a.$);
            b && "group" === b.type && h.W({
                type: "nodeDoubleClick",
                q: b.q,
                metaKey: a.metaKey,
                ctrlKey: a.ctrlKey,
                altKey: a.altKey,
                shiftKey: a.shiftKey
            })
        }

        function T(b) {
            function c(a) {
                for (var b in a) {
                    var e = a[b];
                    e.Aa = e.D - e.m
                }
                return a
            }
            if (A) U = function() {
                T(b)
            };
            else {
                var e = c(z),
                    f = c(k(a, {
                        m: h.Q,
                        D: h.fa
                    }));
                if (0 < h.Y) {
                    Z(C, x.width, x.height);
                    var g = C.getContext("2d");
                    g.save();
                    g.globalAlpha = h.o;
                    g.drawImage(x, 0, 0);
                    g.globalAlpha = h.Y;
                    g.drawImage(L, 0, 0);
                    g.restore();
                    g = x.getContext("2d");
                    g.save();
                    g.globalCompositeOperation = "copy";
                    g.drawImage(C, 0, 0);
                    g.restore()
                }
                var l = x;
                x = L;
                L = l;
                h.Eb = 0;
                h.Y = 1;
                h.o =
                    0;
                h.A();
                W.F.I(h).call(function() {
                    l = z;
                    z = f;
                    Z(x, h.e, h.d);
                    d(x.getContext("2d"), a);
                    z = l
                }).V({
                    target: h,
                    duration: 1E3 * b,
                    O: function() {
                        var a = {},
                            b;
                        for (b in e) {
                            var c = e[b],
                                d = f[b],
                                r = c.m + (d.m - c.m) * h.Eb;
                            a[b] = {
                                m: r,
                                D: r + (c.Aa + (d.Aa - c.Aa) * h.Eb),
                                ba: c.ba
                            }
                        }
                        z = a;
                        h.A()
                    },
                    k: {
                        Eb: {
                            end: 1,
                            f: ta
                        },
                        Y: {
                            end: 0,
                            f: R
                        },
                        o: {
                            end: 1,
                            f: R
                        }
                    }
                }).start()
            }
        }

        function Z(a, b, c) {
            if (a.width != b || a.height != c) a.width = b, a.height = c;
            a.getContext("2d").clearRect(0, 0, b, c)
        }

        function H(a, b) {
            a.lineWidth = 0 < b.lineWidth ? b.lineWidth * c.c : 10;
            a.strokeStyle = b.strokeStyle;
            a.fillStyle =
                b.fillStyle;
            a.globalAlpha = b.globalAlpha
        }
        xa.call(this);
        this.children = [];
        var h = this,
            D, z, E, x = document.createElement("canvas"),
            L = document.createElement("canvas"),
            C;
        Sa && !Ta && (Ta = document.createElement("canvas"));
        C = Ta;
        var A = !1,
            U = null,
            B = !1;
        this.opacity = this.B = this.ra = this.M = this.L = this.d = this.e = this.y = this.x = this.fa = this.Q = this.rotation = this.Y = this.o = 0;
        this.Ie = {
            "default": function(a) {
                return m(s(a))
            },
            implode: function(a) {
                return m(s(a))
            },
            rollout: function(a) {
                return m(ga(a, 0, 100))
            },
            tumbler: function(a) {
                return m(ga(a,
                    720, 0))
            },
            fadein: function(a) {
                return m(N(a, 1))
            }
        };
        this.ue = {
            "default": function(a) {
                return y(a)
            },
            explode: function(a) {
                return y(a)
            },
            rollin: function(a) {
                return u(a, 0)
            },
            fadeout: function(a) {
                return N(a, 0)
            },
            tumbler: function(a) {
                return u(a, 720)
            }
        };
        var V = new function() {
                var b = this;
                xa.call(this);
                this.addEventListener({
                    onSelectionChanged: function() {
                        b.A()
                    },
                    onPaint: function(b) {
                        var e = {
                            lineWidth: c.Zd,
                            fillStyle: c.lc,
                            strokeStyle: c.mc,
                            globalAlpha: h.opacity
                        };
                        H(b.J, e);
                        X(a, function(a) {
                            a.ob() && !1 !== a.visible && t(b.J, a, e)
                        })
                    }
                })
            },
            F =
            new function() {
                xa.call(this);
                this.addEventListener({
                    onPaint: function(a) {
                        if (E && !1 !== E.visible) {
                            var b = [];
                            if (c.Xd)
                                for (var e = E; 0 !== e.id; e = e.parent) b.push(e);
                            else b.push(E);
                            e = {
                                lineWidth: c.Yd,
                                fillStyle: c.gc,
                                strokeStyle: c.hc,
                                globalAlpha: h.opacity
                            };
                            H(a.J, e);
                            for (var d = b.length; 0 <= --d;) !1 !== b[d].visible && t(a.J, b[d], e)
                        }
                    }
                })
            },
            ia = new function() {
                xa.call(this);
                this.addEventListener({
                    onPaint: function(a) {
                        a = a.J;
                        a.save();
                        0 < h.o && (a.globalAlpha = h.o * h.opacity, a.drawImage(x, 0, 0));
                        0 < h.Y && (a.globalAlpha = h.Y * h.opacity, a.drawImage(L,
                            0, 0));
                        a.restore()
                    }
                })
            };
        this.addEventListener({
            onPaint: function(b) {
                a && h.ne(b.J)
            },
            onLayout: function(b) {
                a && h.S(b)
            },
            onClick: function(b) {
                if (!A && a) {
                    var c = p(b.$);
                    c && ("expander" === c.type ? h.W({
                        type: "requestOpenStateChange",
                        za: {
                            nodes: [c.q],
                            open: !c.q.wa()
                        }
                    }) : "group" === c.type && h.W({
                        type: "nodeClick",
                        q: c.q,
                        metaKey: b.metaKey,
                        ctrlKey: b.ctrlKey,
                        altKey: b.altKey,
                        shiftKey: b.shiftKey
                    }))
                }
            },
            onHold: function(b) {
                !A && a && O(b)
            },
            onDoubleClick: function(b) {
                !A && a && O(b)
            },
            onGroupOpenOrClose: function() {
                a && T(c.Kd)
            },
            onGroupZoom: function() {
                a &&
                    T(c.af)
            },
            onMouseMove: function(b) {
                !a || E && z[E.id].R && z[E.id].R(b.$) || ((b = p(b.$)) && "group" === b.type ? g(b.q) : g(void 0))
            },
            onMouseOut: function() {
                a && g(void 0)
            }
        });
        this.S = function(b) {
            b && Q.extend(h, Q.oe(b, Q.keys(h)));
            if (A) B = !0;
            else if (this.oc(), a) {
                Q.X(c.qc) && X(a, function(a) {
                    a.visible = !!c.qc.call(void 0, a.group)
                });
                e();
                X(a, function(a) {
                    a.T = D[a.ea - 1];
                    a.U = D[a.ea]
                });
                a.T = 0;
                a.U = D[0];
                if (Q.X(c.Pc)) {
                    var f = {
                            group: null,
                            maxRadius: h.ra / 2 / c.c,
                            centerx: h.L / c.c,
                            centery: h.M / c.c,
                            r_inner: void 0,
                            r_outer: void 0
                        },
                        g = c.Pc;
                    Pa(a, function(a) {
                        f.r_inner =
                            a.T / c.c;
                        f.r_outer = a.U / c.c;
                        f.group = a.group;
                        g.call(void 0, f);
                        a.T = f.r_inner * c.c;
                        a.U = f.r_outer * c.c;
                        if (isNaN(a.T) || isNaN(a.U)) a.T = 0, a.U = 0
                    })
                }
                h.o = 0;
                h.Y = 0;
                W.F.I(h, "Label paint deferral").gd(1E3 * c.wd).call(function() {
                    Z(x, h.e, h.d);
                    d(x.getContext("2d"), a)
                }).V({
                    target: h,
                    duration: 1E3 * c.ee,
                    O: h.A,
                    k: {
                        o: {
                            end: 1
                        }
                    }
                }).start()
            }
        };
        this.Fb = function() {
            return D.slice()
        };
        this.lb = function(a) {
            return z[a].shape
        };
        this.ne = function(b) {
            a && (0 !== h.opacity && (c.backgroundColor && (b.save(), b.globalAlpha = h.opacity, b.fillStyle = c.backgroundColor,
                b.fillRect(h.x, h.y, h.e, h.d), b.restore()), b.save(), b.globalAlpha = h.opacity, l(b, a), q(b, a), b.restore()), c.Ab && c.Ab())
        };
        this.oc = function() {
            this.Q = Ja(S(c.P));
            this.fa = this.Q + S(c.Ba);
            this.rotation = 0;
            this.L = b(c.L, h.e, c.c) | 0;
            this.M = b(c.M, h.d, c.c) | 0;
            this.ra = b(c.ra, Math.min(h.e, h.d), c.c) | 0
        };
        a && this.children.push(F, V, ia);
        this.oc();
        return this
    }
    var Ta;

    function Ua(a) {
        function c(a) {
            var b, c;

            function e() {
                var d = f.naturalWidth,
                    h = f.naturalHeight,
                    d = d / a.c,
                    h = h / a.c;
                if (Q.X(a.Rb)) {
                    var k = {
                        imageWidth: d,
                        imageHeight: h,
                        layout: {
                            x: g.x,
                            y: g.y,
                            w: g.e,
                            h: g.d
                        }
                    };
                    try {
                        a.Rb.call(void 0, k)
                    } catch (l) {}
                    var w = k.imageWidth;
                    Q.La(w) && (d = Math.max(30, w));
                    w = k.imageHeight;
                    Q.La(w) && (h = Math.max(30, w))
                }
                b = g.x + $.Ac(g.e - d, $.ib(a.od, g.e - d));
                c = g.y + $.Ac(g.d - h, $.ib(a.pd, g.d - h));
                b = Math.round(a.c * b);
                c = Math.round(a.c * c);
                f.width = d * a.c;
                f.height = h * a.c
            }
            xa.call(this);
            var d = this,
                f, g;
            c = b = void 0;
            var h;
            this.opacity =
                0;
            this.addEventListener({
                onLayout: function(k) {
                    Q.extend(a, V);
                    var l = document.createElement("canvas"),
                        m = 0.3 * a.c;
                    l.width = Ra.Yb.width * m;
                    l.height = Ra.Yb.height * m;
                    var Y = l.getContext("2d");
                    Y.scale(m, m);
                    Ra.rd(Y);
                    a.ga = l.toDataURL("image/png");
                    c = b = void 0;
                    a.ga ? (g = {
                        x: k.x / a.c,
                        y: k.y / a.c,
                        e: k.e / a.c,
                        d: k.d / a.c
                    }, f && h === a.ga ? f.naturalWidth && e() : (h = a.ga, f = new Image, f.src = a.ga, f.onload = function() {
                        e();
                        d.A()
                    })) : f = void 0
                },
                onClick: function(e) {
                    if (0 < d.opacity && f && Ba.qe(e.$, {
                            x: b,
                            y: c,
                            e: f.width,
                            d: f.height
                        })) return Q.extend(a, V),
                        a.bb && (document.location.href = a.bb), !1
                },
                onPaint: function(a) {
                    f && void 0 !== b && (a = a.J, a.save(), a.globalAlpha = d.opacity, a.drawImage(f, b, c, f.width, f.height), a.restore())
                }
            })
        }

        function b(a, b) {
            function c(a) {
                a.yc = Math.round((void 0 !== b.Yc ? a.d * b.Yc / 100 + 0.5 | 0 : b.Xa) * b.c);
                a.uc = Math.round((void 0 !== b.Xc ? a.d * b.Xc / 100 + 0.5 | 0 : b.Wa) * b.c)
            }
            xa.call(this);
            var e = this,
                d, f, g = !0,
                h, k = a.ya("selected"),
                l, m = {
                    onHoverChanged: function(a) {
                        h = a.q ? a.q : void 0;
                        e.Ob()
                    },
                    onPostChangeSelection: function(a) {
                        k = a.selected;
                        e.Ob()
                    }
                };
            this.$a = function(a) {
                a.addEventListener(m)
            };
            this.Ad = function(a) {
                a.removeEventListener(m)
            };
            this.Ob = function() {
                var a = void 0;
                h && (a = h.Fa);
                var c = k.Bc;
                Q.j(a) && 0 < c.length && (a = "[" + c[0].Fa + (1 < c.length ? ", ...+" + (c.length - 1) + "]" : "]"));
                b.Lb ? (a = {
                    hoverGroup: h ? h.group : void 0,
                    selectedGroups: k.va,
                    label: a
                }, b.Lb && b.Lb(a), l = a.label) : l = a;
                e.A()
            };
            this.addEventListener({
                onPostLayout: function(a) {
                    f = {
                        x: a.x,
                        y: a.y,
                        e: a.e,
                        d: a.d
                    };
                    switch (b.Vc) {
                        case "none":
                            d = void 0;
                            break;
                        case "top":
                        case "bottom":
                        case "topbottom":
                            d = Q.qa(f);
                            c(d);
                            d.d = d.uc + 2 * b.Mb * b.c;
                            break;
                        case "inscribed":
                            var g =
                                S(35),
                                h = a.Fb[0] * a.c;
                            a = Math.cos(g) * h;
                            g = Math.sin(g) * h;
                            d = {
                                x: f.e / 2 - a,
                                y: f.d / 2 - g,
                                e: 2 * a,
                                d: 2 * g
                            };
                            c(d)
                    }
                    e.Ob()
                },
                onMouseMove: function(a) {
                    g = a.$.y >= f.d / 2
                },
                onClick: function() {},
                onPaint: function(a) {
                    if (d && l) {
                        a = a.J;
                        a.save();
                        switch (b.Vc) {
                            case "topbottom":
                                d.y = g ? 0 : f.d - d.d;
                                break;
                            case "top":
                                d.y = 0;
                                break;
                            case "bottom":
                                d.y = f.d - d.d
                        }
                        0 != b.Ue.jd && (a.fillStyle = b.Wc, a.fillRect(d.x, d.y, d.e, d.d));
                        if (0 != b.We.jd) {
                            var c = Q.qa(d);
                            c.x += b.$c * b.c;
                            c.y += b.Mb * b.c;
                            c.e -= 2 * b.$c * b.c;
                            c.d -= 2 * b.Mb * b.c;
                            if (0 >= c.e || c.d <= d.yc) d = void 0;
                            a.fillStyle = b.Zc;
                            Ca.cc(a, l, c, Q.Nd(b.Ve, b.fc), d.yc, d.uc, b.jc, b.rc, {})
                        }
                        a.restore()
                    }
                }
            })
        }

        function d(b, c) {
            return function(d) {
                if (h && ("mousemove" !== d.type || !(Q.N(d, "movementX") && 0 == d.movementX && 0 == d.movementY || Q.N(d, "mozMovementX") && 0 == d.mozMovementX && 0 == d.mozMovementY || Q.N(d, "webkitMovementX") && 0 == d.webkitMovementX && 0 == d.webkitMovementY))) {
                    var e, g;
                    e = d.pageX;
                    g = d.pageY;
                    if (!e && d.clientX) {
                        e = d.target.ownerDocument || document;
                        g = e.documentElement;
                        var k = e.body;
                        e = d.clientX + (g && g.scrollLeft || k && k.scrollLeft || 0) - (g && g.clientLeft ||
                            k && k.clientLeft || 0);
                        g = d.clientY + (g && g.scrollTop || k && k.scrollTop || 0) - (g && g.clientTop || k && k.clientTop || 0)
                    }
                    d = f(d, {
                        type: b,
                        $: ga(e, g, c, a.c)
                    });
                    x.C(d);
                    return !1
                }
            }
        }

        function e(b, c) {
            return function(d) {
                if (h) {
                    var e = d.dc.touches[0];
                    d = f(d.dc.Ne, {
                        type: b,
                        $: ga("pageX_" in e ? e.pageX_ : e.pageX, "pageY_" in e ? e.pageY_ : e.pageY, c, a.c)
                    });
                    x.C(d);
                    return !1
                }
            }
        }

        function f(a, b) {
            Q.N(a, "altKey") && (b.altKey = a.altKey);
            Q.N(a, "ctrlKey") && (b.ctrlKey = a.ctrlKey);
            Q.N(a, "metaKey") && (b.metaKey = a.metaKey);
            Q.N(a, "shiftKey") && (b.shiftKey = a.shiftKey);
            return b
        }

        function k(b) {
            if (a.ic) {
                var c = {
                    labelText: null
                };
                X(b, function(b) {
                    c.labelText = b.group.label;
                    a.ic(a, N(b), c);
                    b.Fa = c.labelText
                })
            } else X(b, function(a) {
                a.Fa = a.group.label
            })
        }

        function g(b) {
            function c(a) {
                if (a.children) {
                    var b = a.Wd,
                        e = a.children.length - 1,
                        f = Math.min(50, 7 * e),
                        g = Math.max(0, b.l - f / 2);
                    80 < g + f && (g = Math.max(0, 80 - f));
                    for (var h = 0; h <= e; h++) d(a.children[h], {
                        h: b.h,
                        s: 0.8 * b.s,
                        l: Math.ceil(0 == e ? g : g + f * (e - h) / e),
                        a: b.a,
                        model: "hsla"
                    }), c(a.children[h])
                }
            }

            function d(b, c) {
                var f = 0 === a.Ma ? a.sb : 1 === a.Ma ? a.tb : $.Tb(c) >=
                    a.Ma ? a.sb : a.tb;
                a.ec && (f = {
                    labelColor: f,
                    groupColor: c
                }, a.ec(a, N(b), f), c = e(f, "groupColor"), f = "auto" === f.labelColor ? $.Tb(c) >= a.Ma ? a.sb : a.tb : e(f, "labelColor"));
                b.Wd = c;
                b.Vd = $.ad(c);
                b.wf = f;
                b.rc = $.ad(f)
            }

            function e(a, b) {
                var c = a[b];
                Q.pb(c) ? a[b] = c = $.n(c) : Q.j(c) && (a[b] = c = $.n("rgba(0,0,0,0)"));
                $.t(c);
                return c
            }

            function f(a, b, c, d) {
                b = b[d];
                return b + (c[d] - b) * a
            }
            for (var g = 0, h = b.children.length - 1; 0 <= --h;) g += b.children[h].K;
            0 == g && (g = 1);
            var k = a.Ae,
                l = a.ye,
                m = 0;
            wa(b, function(a) {
                var b = m / g;
                m += a.K;
                d(a, {
                    h: f(b, k, l, "h"),
                    s: f(b, k,
                        l, "s"),
                    l: f(b, k, l, "l"),
                    a: f(b, k, l, "a"),
                    model: "hsla"
                });
                c(a)
            })
        }

        function m(a) {
            function b(a, c) {
                var d = {
                    ea: c,
                    group: a,
                    K: 0,
                    rb: function() {
                        return a.zoomed || !1
                    },
                    ob: function() {
                        return a.selected || !1
                    },
                    wa: function() {
                        return a.open || !1
                    }
                };
                a.id && (U[a.id] = d);
                var e = a.groups;
                if (e && 0 < e.length) {
                    for (var f = [], g = 0, h = 0; g < e.length; g++) {
                        var k = b(e[g], c + 1);
                        k.parent = d;
                        k.index = h++;
                        f.push(k)
                    }
                    d.children = f
                }
                return d
            }
            U = {};
            a = b(a, 0);
            l(a);
            q(a);
            p(a);
            var c = 0;
            a.id = 0;
            X(a, function(a) {
                a.id = ++c
            });
            a.children || (a.children = []);
            return a
        }

        function l(a) {
            X(a,
                function(a) {
                    var b = a.group;
                    a.K = Q.N(b, "weight") ? parseFloat(b.weight) : 1
                })
        }

        function q(b) {
            if (a.Me) {
                var c = Number.MAX_VALUE,
                    d = 0;
                wa(b, function(a) {
                    a = a.K;
                    0 < a ? c = Math.min(a, c) : d++
                });
                c == Number.MAX_VALUE && (c = 1);
                wa(b, function(a) {
                    0 >= a.K && (a.K = 0.9 * c);
                    a.children && q(a)
                })
            }
        }

        function p(a) {
            var b = 0;
            wa(a, function(a) {
                b = Math.max(a.K, b)
            });
            0 < b && wa(a, function(a) {
                a.K /= b;
                a.children && p(a.children)
            })
        }

        function t(a, b) {
            if ("random" === b) {
                var c = [],
                    d;
                for (d in a) "default" !== d && c.push(d);
                b = c[Math.floor(Math.random() * (c.length + 1))]
            }
            return a.hasOwnProperty(b) ?
                a[b] : a["default"]
        }

        function s(b) {
            if (h) {
                var c = y(h, b.Ib),
                    d = [];
                if (c) {
                    var e = b.Qa,
                        f = b.value,
                        g = b.Hb;
                    Oa(h, function(a) {
                        var b = a.group[e] || !1;
                        c[a.id] ? b !== f && (a.group[e] = f, d.push(a)) : void 0 !== g && b !== g && (a.group[e] = g, d.push(a))
                    });
                    if (b.Oa)
                        for (var k = 0; k < d.length; k++) {
                            var l = d[k],
                                m = {};
                            m.group = l.group;
                            m[e] = l.group[e];
                            a.tc && window.console.log("Triggering onChange(property=" + b.Qa + ") event", m);
                            b.Oa(m)
                        }
                    b.Sa && x.C({
                        type: b.Sa,
                        Bc: d
                    })
                }
                return d
            }
        }

        function y(a, b) {
            var c = {};
            if (Q.da(b) && b.all) return Oa(a, function(a) {
                    c[a.id] = !0
                }),
                c;
            if (Q.da(b) && Q.isArray(b.nodes))
                for (var d = b.nodes, e = d.length; 0 <= --e;) c[d[e].id] = !0;
            var f = {};
            Q.da(b) && Q.N(b, "groups") && (b = Q.isArray(b.groups) ? b.groups : [b.groups]);
            if (Q.isArray(b))
                for (e = b.length; 0 <= --e;) f[b[e]] = !0;
            Q.da(b) || (f[b] = !0);
            Oa(a, function(a) {
                void 0 !== a.group.id && f[a.group.id] && (c[a.id] = !0)
            });
            return c
        }

        function u(a, b, c) {
            return Q.da(a) && b in a ? a[b] : c
        }

        function N(a) {
            var b = {};
            b.group = a.group;
            b.weightNormalized = a.K;
            b.level = a.ea - 1;
            b.index = a.index;
            b.siblingCount = a.parent.children.length;
            return b
        }

        function ga(a,
            b, c, d) {
            var e;
            var f = {
                    top: 0,
                    left: 0
                },
                g = c && c.ownerDocument;
            g ? (e = g.documentElement, "undefined" !== typeof c.getBoundingClientRect && (f = c.getBoundingClientRect()), c = null != g && g == g.window ? g : 9 === g.nodeType ? g.defaultView || g.parentWindow : !1, e = {
                top: f.top + (c.pageYOffset || e.scrollTop) - (e.clientTop || 0),
                left: f.left + (c.pageXOffset || e.scrollLeft) - (e.clientLeft || 0)
            }) : e = void 0;
            return {
                x: (a - e.left) * d,
                y: (b - e.top) * d
            }
        }

        function O() {
            B = Q.qa(a);
            D = new Sa(h, B);
            L.Za(D);
            z && C.Gb(z);
            z = new c(B);
            C.Za(z);
            E && (E.Ad(x), C.Gb(E));
            E = new b(H, B);
            E.$a(x);
            C.Za(E)
        }
        var T = {},
            Z = {},
            H = this,
            h, D, z, E, x = new ya,
            L, C, A, U, B = {},
            V = {
                Da: void 0,
                ab: void 0,
                bb: $.Je(),
                ga: void 0
            },
            F;
        this.mb = function(b) {
            var c = document.createElement("canvas");
            c.setAttribute("style", "position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%; -webkit-touch-callout: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;");
            b.parentNode.insertBefore(c, b.nextSibling);
            x.Pb("main", L = new za(b, "main"));
            x.Pb("overlay", C = new za(c,
                "overlay"));
            O();
            x.addEventListener({
                onHoverChanged: function(b) {
                    a.Fc({
                        group: b.q ? b.q.group : null
                    })
                },
                onRequestSelectionChange: function(a) {
                    H.Wb(a.za)
                },
                onRequestOpenStateChange: function(a) {
                    H.cb(a.za)
                },
                onRequestZoomStateChange: function(a) {
                    H.Xb(a.za)
                },
                onPostChangeSelection: function(b) {
                    b.Ke && a.yb && (b = b.selected.va, a.tc && window.console.log("Triggering onGroupSelectionChanged event", b), a.yb({
                        groups: b
                    }))
                },
                onNodeDoubleClick: function(b) {
                    var c = b.q;
                    Q.contains(a.Dc({
                        group: c.group,
                        metaKey: b.metaKey,
                        ctrlKey: b.ctrlKey,
                        altKey: b.altKey,
                        shiftKey: b.shiftKey
                    }), !1) || x.W({
                        type: "requestZoomStateChange",
                        za: {
                            nodes: [c],
                            zoomed: !c.rb(),
                            resetValue: b.metaKey | b.ctrlKey ? !1 : void 0
                        }
                    });
                    a.xb && a.xb({
                        group: c.group,
                        metaKey: b.metaKey,
                        ctrlKey: b.ctrlKey,
                        altKey: b.altKey,
                        shiftKey: b.shiftKey
                    })
                },
                onNodeClick: function(b) {
                    var c = b.q;
                    Q.contains(a.Cc({
                        group: c.group,
                        metaKey: b.metaKey,
                        ctrlKey: b.ctrlKey,
                        altKey: b.altKey,
                        shiftKey: b.shiftKey
                    }), !1) || x.W({
                        type: "requestSelectionChange",
                        za: {
                            nodes: [c],
                            selected: !c.ob(),
                            resetValue: b.metaKey | b.ctrlKey ? void 0 : !1
                        }
                    });
                    a.wb && a.wb({
                        group: c.group,
                        metaKey: b.metaKey,
                        ctrlKey: b.ctrlKey,
                        altKey: b.altKey,
                        shiftKey: b.shiftKey
                    })
                }
            });
            F = new la(c, {
                Db: a.Vb
            });
            F.ja("tap", e("click", c));
            F.ja("doubletap", e("doubleClick", c));
            F.ja("hold", e("hold", c));
            "ontouchstart" in window || (c.addEventListener("mousemove", d("mouseMove", c), !1), c.addEventListener("mouseout", d("mouseOut", c), !1))
        };
        var ia = [];
        this.reload = function() {
            var b = {
                root: h,
                ka: D,
                options: B
            };
            h = a.eb ? m(a.eb) : void 0;
            O();
            a.Jc(a.eb);
            H.S();
            H.Ra();
            var c = {
                root: h,
                ka: D,
                options: B
            };
            (function() {
                Q.extend(a,
                    V);
                var b = W.F.I(Z, "attribution").V({
                    target: z,
                    duration: Q.j(a.Ca) ? 0 : 1E3 * Math.min(5, a.Ca),
                    k: {
                        opacity: {
                            end: 1,
                            f: R
                        }
                    },
                    O: z.A
                });
                !Q.j(a.Da) && 0 < a.Da && b.gd(1E3 * a.Da).V({
                    target: z,
                    duration: Q.j(a.ab) ? 0 : 1E3 * a.ab,
                    k: {
                        opacity: {
                            end: 0,
                            f: R
                        }
                    },
                    O: z.A
                });
                b.start()
            })();
            (function(b, c) {
                ia = Q.filter(ia, function(a) {
                    return a.nb()
                });
                var d = ia.slice(),
                    e = [],
                    f = [],
                    g = a.vb,
                    d = W.F.ja(T, "Reload model").Cb(d).call(function() {
                        var a = t(b.ka.ue, b.options.se)(b.root ? b.options.te : 0).Ga(),
                            d = t(c.ka.Ie, c.options.Ge)(c.options.He).Ga();
                        e.push(a);
                        c.ka ===
                            D && ("parallel" == g ? e.push(d) : f.push(d));
                        c.options.Lc()
                    }).Cb(e).call(function() {
                        L.Gb(b.ka);
                        c.ka !== D && (f.length = 0)
                    }).Cb(f).call(function() {
                        Aa.Mc(function() {
                            c.options.Kc(H.Uc())
                        })
                    }).Ga();
                "sequential" == g && ia.push(d);
                d.start()
            })(b, c)
        };
        this.Uc = function() {
            return {}
        };
        this.lb = function(a) {
            return h ? D.lb(U[a].id) : {}
        };
        this.S = function() {
            if (h) {
                var b = L.canvas,
                    c = b.clientWidth * a.c,
                    b = b.clientHeight * a.c;
                if (0 == c || 0 == b) b = c = 1;
                l(h);
                q(h);
                p(h);
                g(h);
                k(h);
                x.C({
                    type: "layout",
                    x: 0,
                    y: 0,
                    e: c,
                    d: b,
                    root: h,
                    options: a
                });
                var d = 1 / a.c,
                    e = Q.map(D.Fb(),
                        function(a) {
                            return a * d
                        });
                x.C({
                    root: h,
                    type: "postLayout",
                    x: 0,
                    y: 0,
                    e: c,
                    d: b,
                    c: a.c,
                    Fb: e,
                    options: a
                });
                A = {
                    x: 0,
                    y: 0,
                    w: c * d,
                    h: b * d,
                    pixelRatio: a.c,
                    centerx: D.L * d,
                    centery: D.M * d,
                    radii: e
                };
                a.zb && a.zb(A)
            }
        };
        this.fe = function() {
            return h ? A : void 0
        };
        this.Ra = function() {
            h && x.C({
                type: "dirty"
            })
        };
        this.cb = function(b, c) {
            h && (Q.j(c) && (c = !0), s({
                Ib: b,
                Qa: "open",
                value: u(b, "open", !0),
                Hb: u(b, "resetValue", void 0),
                Oa: c ? u(b, "onChange", a.Gc) : void 0,
                Sa: "groupOpenOrClose"
            }))
        };
        this.Xb = function(b, c) {
            h && (Q.j(c) && (c = !0), s({
                Ib: b,
                Qa: "zoomed",
                value: u(b,
                    "zoomed", !0),
                Hb: u(b, "resetValue", void 0),
                Oa: c ? u(b, "onChange", a.Ic) : void 0,
                Sa: "groupZoom"
            }))
        };
        this.Wb = function(b, c) {
            if (h) {
                Q.j(c) && (c = !0);
                var d = s({
                    Ib: b,
                    Qa: "selected",
                    value: u(b, "selected", !0),
                    Hb: u(b, "resetValue", void 0),
                    Oa: c ? u(b, "onChange", a.Hc) : void 0,
                    Sa: "selectionChanged"
                });
                if (!Q.N(b, "open") || b.open) {
                    var e = [];
                    d.forEach(function(b) {
                        if (b.ob())
                            for (; b.parent;) !b.parent.wa() && b.index >= a.na && e.push(b.parent), b = b.parent;
                        return !1
                    });
                    0 < e.length && this.cb({
                        nodes: e,
                        open: !0
                    }, c)
                }
                x.C({
                    type: "postChangeSelection",
                    selected: H.ya("selected"),
                    Ke: c
                })
            }
        };
        this.td = function() {
            return {
                groups: H.ya("open").va
            }
        };
        this.ud = function() {
            return {
                groups: H.ya("selected").va
            }
        };
        this.vd = function() {
            return {
                groups: H.ya("zoomed").va
            }
        };
        this.be = function(b) {
            var c = $.fb(b, "format", "image/png"),
                d = $.fb(b, "quality", 0.8),
                e = a.c;
            b = $.fb(b, "pixelRatio", e);
            var f = document.createElement("canvas");
            if (h) try {
                b != e && (a.c = b, H.S());
                x.C({
                    type: "paint"
                });
                var g = L.canvas;
                f.width = g.width;
                f.height = g.height;
                var k = f.getContext("2d");
                k.save();
                x.sc.forEach(function(a) {
                    k.globalAlpha = "" === a.canvas.style.opacity ?
                        1 : a.canvas.style.opacity;
                    k.drawImage(a.canvas, 0, 0)
                });
                k.restore()
            } finally {
                b != e && (a.c = e, H.S(), x.C({
                    type: "paint"
                }))
            }
            return f.toDataURL(c, d)
        };
        this.nd = function() {
            Q.extend(B, a);
            F && (F.options.Db = B.Vb)
        };
        this.ya = function(a) {
            var b = [],
                c = [];
            h && Oa(h, function(d) {
                d.group[a] && (b.push(d), c.push(d.group))
            });
            return {
                Bc: b,
                va: c
            }
        }
    }

    function Va() {
        return {
            version: "2.3.0",
            build: "master/509263c0",
            brandingAllowed: !1
        }
    };
    window.CarrotSearchCircles = function(a) {
        function c(a) {
            function c(a) {
                return /%$/.test(a) ? parseFloat(a.replace(/[%\s]/g, "")) : void 0
            }

            function k(a) {
                return Q.j(a) || Q.La(a) ? a : parseFloat(a.replace(/[%\s]/g, ""))
            }

            function q(a) {
                return function() {
                    return a ? a.apply(b, arguments) : void 0
                }
            }

            function p(a) {
                function c() {
                    var a = [],
                        e = arguments;
                    Q.forEach(d, function(c) {
                        a.push(c.apply(b, e))
                    });
                    return a
                }
                var d = [];
                Q.isArray(a) ? Q.forEach(a, function(a) {
                    Q.X(a) && d.push(a)
                }) : Q.X(a) && d.push(a);
                c.v = function() {
                    return Q.qa(d)
                };
                return c
            }(function() {
                e.id =
                    d.id;
                e.L = d.centerx;
                e.M = d.centery;
                e.ra = d.diameter;
                e.eb = d.dataObject;
                e.tc = d.logging;
                e.Tc = d.textureMappingMesh;
                e.backgroundColor = d.backgroundColor;
                e.jf = $.t($.n(e.backgroundColor));
                e.Fe = d.ringScaling;
                e.Pc = d.ringShape;
                e.na = d.visibleGroupCount;
                e.hd = d.zoomedFraction;
                e.Kd = d.expandTime;
                e.af = d.zoomTime;
                e.Ld = d.expanderAngle;
                e.ke = d.minExpanderAngle;
                e.bc = d.expanderOutlineWidth;
                e.ac = d.expanderOutlineColor;
                e.mf = $.t($.n(e.ac));
                e.$b = d.expanderColor;
                e.lf = $.t($.n(e.$b));
                e.$e = d.zoomDecorationStrokeColor;
                e.Ze = d.zoomDecorationFillColor;
                e.wd = d.deferLabelRedraws;
                e.ee = d.labelRedrawFadeInTime;
                e.P = d.angleStart;
                e.Z = d.angleEnd;
                e.Ba = d.angleWidth;
                if (!Q.j(e.Z)) {
                    e.P = Ia(e.P);
                    e.Z = Ia(e.Z);
                    if (e.P >= e.Z) {
                        var a = e.P;
                        e.P = e.Z;
                        e.Z = a
                    }
                    e.Ba = e.Z - e.P;
                    0 == Ia(e.Ba) && 0 != d.angleEnd && (e.Ba = 360)
                }
                e.Ge = d.rolloutAnimation;
                e.He = d.rolloutTime;
                e.se = d.pullbackAnimation;
                e.te = d.pullbackTime;
                e.ze = d.rainbowStartColor;
                e.Ae = $.t($.n(e.ze));
                e.xe = d.rainbowEndColor;
                e.ye = $.t($.n(e.xe));
                e.Xd = d.groupHoverHierarchy;
                e.gc = d.groupHoverColor;
                e.of = $.t($.n(e.gc));
                e.Yd = d.groupHoverOutlineWidth;
                e.hc = d.groupHoverOutlineColor;
                e.pf = $.t($.n(e.hc));
                e.lc = d.groupSelectionColor;
                e.rf = $.t($.n(e.lc));
                e.Zd = d.groupSelectionOutlineWidth;
                e.mc = d.groupSelectionOutlineColor;
                e.sf = $.t($.n(e.mc));
                e.Ka = d.groupOutlineWidth;
                e.kc = d.groupOutlineColor;
                e.qf = $.t($.n(e.kc));
                e.de = d.labelLightColor;
                e.tb = $.t($.n(e.de));
                e.ce = d.labelDarkColor;
                e.sb = $.t($.n(e.ce));
                e.Ma = d.labelColorThreshold;
                e.fc = d.groupFontFamily;
                e.Ja = d.groupMinFontSize;
                e.Ia = d.groupMaxFontSize;
                e.jc = d.groupLinePadding;
                e.ic = q(d.groupLabelDecorator);
                e.ec = q(d.groupColorDecorator);
                e.md = d.angularTextureStep;
                e.we = d.radialTextureStep;
                e.Te = d.textureOverlapFudge;
                e.me = d.noTexturingCurvature;
                e.De = d.ratioRadialPadding;
                e.le = d.minRadialPadding;
                e.Be = d.ratioAngularPadding;
                e.je = d.minAngularPadding;
                e.Ce = d.ratioAspectSwap;
                e.qc = d.isGroupVisible;
                e.Jc = p(d.onModelChanged);
                e.Lc = p(d.onRolloutStart);
                e.Kc = p(d.onRolloutComplete);
                e.Ab = p(d.onRedraw);
                e.zb = p(d.onLayout);
                e.Fc = p(d.onGroupHover);
                e.Gc = p(d.onGroupOpenOrClose);
                e.Ic = p(d.onGroupZoom);
                e.Hc = p(d.onGroupSelectionChanging);
                e.yb = p(d.onGroupSelectionChanged);
                e.Cc = p(d.onBeforeSelection);
                e.Dc = p(d.onBeforeZoom);
                e.wb = p(d.onGroupClick);
                e.xb = p(d.onGroupDoubleClick);
                e.Me = d.showZeroWeightGroups;
                e.c = d.pixelRatio;
                e.Vb = d.captureMouseEvents;
                e.ga = d.attributionLogo;
                e.bb = d.attributionUrl;
                e.od = d.attributionPositionX;
                e.pd = d.attributionPositionY;
                e.ab = d.attributionFadeOutTime;
                e.Da = d.attributionStayOnTime;
                e.Rb = d.attributionSize;
                e.Vc = d.titleBar;
                e.Ve = d.titleBarFontFamily;
                e.Xa = d.titleBarMinFontSize;
                e.Wa = d.titleBarMaxFontSize;
                e.Wc = d.titleBarBackgroundColor;
                e.Ue = $.t($.n(e.Wc));
                e.Zc = d.titleBarTextColor;
                e.We = $.t($.n(e.Zc));
                e.$c = d.titleBarTextPaddingLeftRight;
                e.Mb = d.titleBarTextPaddingTopBottom;
                e.Lb = d.titleBarLabelDecorator;
                e.Ca = Number(d.attributionFadeInTime);
                isNaN(e.Ca) && (e.Ca = 0);
                e.zc = c(e.Ja);
                e.vc = c(e.Ia);
                e.Ja = k(e.Ja);
                e.Ia = k(e.Ia);
                e.Yc = c(e.Xa);
                e.Xa = k(e.Xa);
                e.Xc = c(e.Wa);
                e.Wa = k(e.Wa);
                e.na || (e.na = Number.MAX_VALUE);
                e.vb = d.modelChangeAnimations;
                "auto" == e.vb && (e.vb = /iPad|iPhone/.test(window.navigator.userAgent) ? "sequential" : "parallel")
            })();
            for (var t = "dataObject showZeroWeightGroups attributionLogo attributionStayOnTime attributionFadeOutTime attributionFadeInTime pixelRatio".split(" "),
                    s = !1, y = 0; y < t.length; y++)
                if ("undefined" != typeof a[t[y]]) {
                    f.reload();
                    s = !0;
                    break
                }
            f.nd();
            if (!s)
                for (t = "centerx centery diameter ringScaling ringShape visibleGroupCount zoomedFraction expanderAngle minExpanderAngle angleStart angleEnd angleWidth rainbowStartColor rainbowEndColor labelColorThreshold labelDarkColor labelLightColor groupFontFamily groupMinFontSize groupMaxFontSize groupLinePadding ratioRadialPadding minRadialPadding ratioAngularPadding minAngularPadding groupLabelDecorator groupColorDecorator textureMappingMesh radialTextureStep angularTextureStep textureOverlapFudge attributionLogo attributionUrl attributionPositionX attributionPositionY attributionSize attributionFadeOutTime attributionStayOnTime noTexturingCurvature isGroupVisible ratioAspectSwap titleBar titleBarFontFamily titleBarMinFontSize titleBarMaxFontSize titleBarBackgroundColor titleBarTextColor titleBarTextPaddingLeftRight titleBarTextPaddingTopBottom titleBarLabelDecorator zoomDecorationStrokeColor zoomDecorationFillColor".split(" "),
                    y = 0; y < t.length; y++)
                    if ("undefined" != typeof a[t[y]]) {
                        f.S();
                        f.Ra();
                        break
                    }
                    "undefined" !== typeof a.selection && (delete d.selection, f.Wb(a.selection, !1));
            "undefined" !== typeof a.open && (delete d.open, f.cb(a.open, !1));
            "undefined" !== typeof a.zoom && (delete d.zoom, f.Xb(a.zoom, !1))
        }
        if (window.CarrotSearchCircles.supported) {
            var b = this;
            a = (new Qa).mb(this, {
                Ya: "Carrot Search HTML5 Circles",
                Le: a,
                H: {
                    id: null,
                    dataObject: null,
                    logging: !1,
                    times: null,
                    textureMappingMesh: !1,
                    backgroundColor: "rgba(0, 0, 0, 0)",
                    centerx: "50%",
                    centery: "50%",
                    diameter: "99%",
                    layout: void 0,
                    ringScaling: 0.75,
                    ringShape: void 0,
                    angleStart: 0,
                    angleEnd: void 0,
                    angleWidth: 360,
                    showZeroWeightGroups: !0,
                    visibleGroupCount: 6,
                    zoomedFraction: 0.75,
                    groupOutlineWidth: 1,
                    groupOutlineColor: "rgba(0, 0, 0, 0.5)",
                    rainbowStartColor: "hsla(0, 100%, 50%, 0.7)",
                    rainbowEndColor: "hsla(300, 100%, 50%, 0.7)",
                    labelDarkColor: "rgba(0, 0, 0, 0.8)",
                    labelLightColor: "rgba(255, 255, 255, 0.8)",
                    labelColorThreshold: 0.35,
                    groupColorDecorator: null,
                    groupFontFamily: "Impact, Charcoal, sans-serif",
                    groupMinFontSize: "5",
                    groupMaxFontSize: "30",
                    groupLinePadding: 1,
                    groupLabelDecorator: null,
                    ratioAspectSwap: 0.8,
                    ratioRadialPadding: 0.1,
                    minRadialPadding: 4,
                    ratioAngularPadding: 0.2,
                    minAngularPadding: 2,
                    radialTextureStep: 30,
                    angularTextureStep: 25,
                    noTexturingCurvature: 0.1,
                    textureOverlapFudge: navigator.userAgent.match(/Chrome/i) ? 0 : 0.5,
                    deferLabelRedraws: 0.25,
                    labelRedrawFadeInTime: 0.5,
                    expanderAngle: 2,
                    minExpanderAngle: 1,
                    expanderOutlineWidth: 1,
                    expanderOutlineColor: "rgba(0, 0, 0, .2)",
                    expanderColor: "rgba(255, 136, 136, 0.8)",
                    expandTime: 1,
                    zoomDecorationStrokeColor: "hsla(0, 0%, 0%, 0.2)",
                    zoomDecorationFillColor: "hsla(0, 0%, 0%, 0.1)",
                    zoomTime: 1,
                    rolloutAnimation: "random",
                    rolloutTime: 1,
                    pullbackAnimation: "random",
                    pullbackTime: 0.5,
                    modelChangeAnimations: "auto",
                    groupSelectionColor: "rgba(255, 128, 128, 0.1)",
                    groupSelectionOutlineColor: "rgba(255, 128, 128, 1)",
                    groupSelectionOutlineWidth: 3,
                    groupHoverColor: "rgba(0, 0, 227, 0.1)",
                    groupHoverOutlineColor: "rgba(0, 0, 227, 0.1)",
                    groupHoverOutlineWidth: 1,
                    groupHoverHierarchy: !0,
                    selection: null,
                    open: null,
                    zoom: null,
                    imageData: null,
                    attributionLogo: "carrotsearch",
                    attributionUrl: "http://carrotsearch.com/circles",
                    attributionPositionX: "3%",
                    attributionPositionY: "97%",
                    attributionSize: void 0,
                    attributionStayOnTime: 3,
                    attributionFadeOutTime: 3,
                    attributionFadeInTime: 0.5,
                    titleBar: "none",
                    titleBarFontFamily: void 0,
                    titleBarMinFontSize: 8,
                    titleBarMaxFontSize: 40,
                    titleBarBackgroundColor: "rgba(0, 0, 0, 0)",
                    titleBarTextColor: "rgba(255, 255, 255, .7)",
                    titleBarTextPaddingLeftRight: 5,
                    titleBarTextPaddingTopBottom: 5,
                    titleBarLabelDecorator: void 0,
                    isGroupVisible: null,
                    onModelChanged: void 0,
                    onRolloutStart: void 0,
                    onRolloutComplete: void 0,
                    onRedraw: void 0,
                    onLayout: void 0,
                    onGroupHover: void 0,
                    onGroupZoom: void 0,
                    onGroupOpenOrClose: void 0,
                    onGroupSelectionChanging: void 0,
                    onGroupSelectionChanged: void 0,
                    onGroupClick: void 0,
                    onGroupDoubleClick: void 0,
                    onBeforeZoom: void 0,
                    onBeforeSelection: void 0,
                    pixelRatio: 1,
                    captureMouseEvents: !0
                },
                Qb: {},
                oa: {
                    get: function(a, b) {
                        switch (a) {
                            case "selection":
                                return f.ud();
                            case "open":
                                return f.td();
                            case "zoom":
                                return f.vd();
                            case "times":
                                return f.Uc();
                            case "layout":
                                return f.fe();
                            case "imageData":
                                return f.be(b[0]);
                            case "onModelChanged":
                                return e.Jc.v();
                            case "onRolloutStart":
                                return e.Lc.v();
                            case "onRolloutComplete":
                                return e.Kc.v();
                            case "onRedraw":
                                return e.Ab.v();
                            case "onLayout":
                                return e.zb.v();
                            case "onGroupHover":
                                return e.Fc.v();
                            case "onGroupOpenOrClose":
                                return e.Gc.v();
                            case "onGroupZoom":
                                return e.Ic.v();
                            case "onBeforeSelection":
                                return e.Cc.v();
                            case "onBeforeZoom":
                                return e.Dc.v();
                            case "onGroupClick":
                                return e.wb.v();
                            case "onGroupDoubleClick":
                                return e.xb.v();
                            case "onGroupSelectionChanging":
                                return e.Hc.v();
                            case "onGroupSelectionChanged":
                                return e.yb.v();
                            default:
                                return d[a]
                        }
                    },
                    set: c,
                    fd: function(a) {
                        var b = window.CarrotSearchCircles.attributes;
                        if (b) {
                            var c = Va().version;
                            Q.forEach(a, function(d, e) {
                                try {
                                    b[e] && b[e].asserts && (b[e].asserts.validate(d), b[e].deprecated && window.console && window.console.warn("Attribute '" + e + "' has been deprecated in version " + b[e].deprecated + " (you are using version " + c + ")"))
                                } catch (f) {
                                    window.console && (window.console.error("Attribute validation failed for '" +
                                        e + "': " + f), window.console.log("Expected value for '" + e + "': " + b[e].asserts)), delete a[e]
                                }
                            })
                        }
                    }
                }
            });
            var d = a.options,
                e = {},
                f = new Ua(e);
            c({});
            if (e.id) {
                var k = a.Id(e.id);
                k && (this.resize = function() {
                    var a = e.c;
                    return !k || k.width == k.clientWidth * a && k.height == k.clientHeight * a ? !1 : (f.S(), f.Ra(), !0)
                }, this.redraw = function() {
                    f.Ra()
                }, this.layout = function() {
                    f.S()
                }, this.dispose = function() {}, this.version = Va, this.groupShape = function(a) {
                    return f.lb(a)
                }, f.mb(k), f.reload())
            }
        }
    };
    var Ya = window.CarrotSearchCircles,
        Za, $a = document.createElement("canvas");
    Za = !(!$a.getContext || !$a.getContext("2d"));
    Ya.supported = Za;
    window.CarrotSearchCircles.version = Va;
    var ab = window.CarrotSearchCircles,
        bb;
    var cb = window["CarrotSearchCircles.attributes"];
    cb ? (delete window["CarrotSearchCircles.attributes"], bb = cb) : bb = {};
    ab.attributes = bb;
})();