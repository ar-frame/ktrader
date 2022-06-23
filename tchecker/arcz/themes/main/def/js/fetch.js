! function(e) {
    var t = {};

    function r(n) {
        if (t[n])
            return t[n].exports;
        var o = t[n] = {
            i: n,
            l: !1,
            exports: {}
        };
        return e[n].call(o.exports, o, o.exports, r),
            o.l = !0,
            o.exports
    }
    r.m = e,
        r.c = t,
        r.d = function(e, t, n) {
            r.o(e, t) || Object.defineProperty(e, t, {
                enumerable: !0,
                get: n
            })
        },
        r.r = function(e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
                    value: "Module"
                }),
                Object.defineProperty(e, "__esModule", {
                    value: !0
                })
        },
        r.t = function(e, t) {
            if (1 & t && (e = r(e)),
                8 & t)
                return e;
            if (4 & t && "object" == typeof e && e && e.__esModule)
                return e;
            var n = Object.create(null);
            if (r.r(n),
                Object.defineProperty(n, "default", {
                    enumerable: !0,
                    value: e
                }),
                2 & t && "string" != typeof e)
                for (var o in e)
                    r.d(n, o, function(t) {
                            return e[t]
                        }
                        .bind(null, o));
            return n
        },
        r.n = function(e) {
            var t = e && e.__esModule ? function() {
                    return e.default
                } :
                function() {
                    return e
                };
            return r.d(t, "a", t),
                t
        },
        r.o = function(e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        },
        r.p = "",
        r(r.s = 2)
}([function(e, t, r) {
    "use strict";
    var n = function() {
        if ("undefined" != typeof self)
            return self;
        if ("undefined" != typeof window)
            return window;
        if (void 0 !== n)
            return n;
        throw new Error("unable to locate global object")
    }();
    e.exports = t = n.fetch,
        t.default = n.fetch.bind(n),
        t.Headers = n.Headers,
        t.Request = n.Request,
        t.Response = n.Response
}, function(e, t) {
    e.exports = "object" == typeof self ? self.FormData : window.FormData
}, function(e, t, r) {
    "use strict";
    r.r(t);
    var n = class {
        constructor(e, t) {
            this.SERVER_ADDRESS = e,
                this.AUTH_SERVER_OPKEY = t,
                this.USER_ACCESS_TOKEN = "default_acc_key",
                this.SERVER_RESPONSE_TAG = "___SERVICE_STD_OUT_SEP___"
        }
        setUserAuthKey(e) {
            this.USER_AUTH_KEY = e
        }
    };
    var o = class {
        static str2HexStr(e) {
            if ("" === e)
                return "";
            for (var t = [], r = 0; r < e.length; r++)
                t.push(e.charCodeAt(r).toString(16));
            return t.join("").toUpperCase()
        }
        static hexStr2Str(e) {
            var t, r = e.trim(),
                n = r.length;
            if (n % 2 != 0)
                return console.log("Illegal Format ASCII Code!"),
                    "";
            for (var o = [], a = 0; a < n; a += 2)
                t = parseInt(r.substr(a, 2), 16),
                o.push(String.fromCharCode(t));
            return o.join("")
        }
        static randomString(e) {
            e = e || 32;
            var t = "ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678",
                r = t.length,
                n = "",
                o = 0;
            for (o = 0; o < e; o++)
                n += t.charAt(Math.floor(Math.random() * r));
            return n
        }
        static urlencode(e) {
            let t = [],
                r = "";
            t = Array.from(e);
            for (let e of t) {
                let t = /\uD83C[\uDF00-\uDFFF]|\uD83D[\uDC00-\uDE4F]/g;
                r += e.match(t) ? encodeURIComponent(e) : this.encodeNoEmoji(e)
            }
            return r
        }
        static encodeNoEmoji(e) {
            var t = "",
                r = 0;
            e = this.utf16to8(e.toString());
            for (var n = /(^[a-zA-Z0-9-_.]*)/; r < e.length;) {
                var o = n.exec(e.substr(r));
                if (null !== o && o.length > 1 && "" !== o[1])
                    t += o[1],
                    r += o[1].length;
                else {
                    if (" " === e[r])
                        t += "+";
                    else {
                        var a = e.charCodeAt(r).toString(16);
                        t += "%" + (a.length < 2 ? "0" : "") + a.toUpperCase()
                    }
                    r++
                }
            }
            return t
        }
        static utf16to8(e) {
            var t, r, n, o;
            for (t = "",
                n = e.length,
                r = 0; r < n; r++)
                (o = e.charCodeAt(r)) >= 1 && o <= 127 ? t += e.charAt(r) : o > 2047 ? (t += String.fromCharCode(224 | o >> 12 & 15),
                    t += String.fromCharCode(128 | o >> 6 & 63),
                    t += String.fromCharCode(128 | o >> 0 & 63)) : (t += String.fromCharCode(192 | o >> 6 & 31),
                    t += String.fromCharCode(128 | o >> 0 & 63));
            return t
        }
    };
    class a extends Error {
        constructor(e) {
            super(e),
                this.name = "ServerResponseException",
                this.message = this.name + ": " + (e || "Error")
        }
    }
    var s = a,
        i = r(0),
        u = r.n(i),
        c = r(1),
        l = r.n(c);
    var f = class {
        constructor(e) {
            this.config = e
        }
        getResponse(e, t) {
            let r = this.config;
            const n = new l.a;
            n.append("ws", e),
                u()(r.SERVER_ADDRESS, {
                    method: "POST",
                    body: n
                }).then(e => e.text()).then(e => {
                    if (!(e.length > 0))
                        throw new s("return empty"); {
                        let n = e.indexOf(r.SERVER_RESPONSE_TAG);
                        if (!(n >= 0))
                            throw new s("err data:" + e); {
                            let a = e.substring(n + r.SERVER_RESPONSE_TAG.length);
                            a = o.hexStr2Str(a),
                                t(a)
                        }
                    }
                })
        }
        sendRequest(e, t, r, n) {
            let a = {
                    type: "array"
                },
                s = {},
                i = this.config;
            s.AUTH_SERVER_OPKEY = i.AUTH_SERVER_OPKEY,
                s.USER_AUTH_KEY = i.USER_AUTH_KEY,
                s.USER_ACCESS_TOKEN = i.USER_ACCESS_TOKEN;
            let u = {};
            u.class = e,
                u.method = t,
                r && r.length > 0 ? u.param = JSON.stringify(r) : u.param = '[""]',
                u.authSign = s,
                u.CLIENT_SERVER = "GETCODER-NODEJS-SDK-20191108",
                a.data = u;
            let c = JSON.stringify(a);
            c = o.urlencode(c);
            let l = o.str2HexStr(c);
            return this.getResponse(l, (function(e) {
                n && n(e)
            }))
        }
        getObject(e, t, r, n) {
            return this.sendRequest(e, t, r, (function(e) {
                let t = JSON.parse(e);
                if ("object" != t.type)
                    throw new s("type check error, 'object' expected but " + t.type + " provided," + e);
                n && n(t.data)
            }))
        }
        getArray(e, t, r, n) {
            return this.sendRequest(e, t, r, (function(e) {
                let t = JSON.parse(e);
                if ("array" != t.type)
                    throw new s("type check error, 'array' expected but " + t.type + " provided," + e);
                n && n(t.data)
            }))
        }
        getInt(e, t, r, n) {
            return this.sendRequest(e, t, r, (function(e) {
                let t = JSON.parse(e);
                if ("int" != t.type)
                    throw new s("type check error, 'int' expected but " + t.type + " provided," + e);
                n && n(parseInt(t.data))
            }))
        }
        getDouble(e, t, r, n) {
            return this.sendRequest(e, t, r, (function(e) {
                let t = JSON.parse(e);
                if ("float" != t.type)
                    throw new s("type check error, 'float' expected but " + t.type + " provided," + e);
                n && n(parseFloat(t.data))
            }))
        }
        getFloat(e, t, r, n) {
            return this.getDouble(e, t, r, n)
        }
        getBool(e, t, r, n) {
            return this.sendRequest(e, t, r, (function(e) {
                let t = JSON.parse(e);
                if ("bool" != t.type)
                    throw new s("type check error, 'bool' expected but " + t.type + " provided," + e);
                n && n(Boolean(t.data))
            }))
        }
    };
    try { 
        <if exp = "$_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1' || strpos($_SERVER['SERVER_NAME'],'192.168') !== false" >
            let e = new n("http://192.168.101.27/sg2/server/arws.php", "aaaaaaaabbbialasdddggSG2022ldshgaccccc"); 
            <else />
        let e = new n("{{\ar\core\cfg('SDK_ONLINE_SERVER')}}", "aaaaaaaabbbialasdddggSG2022ldshgaccccc"); </if>
        e.setUserAuthKey("from cpp client init 1.2"),
            e.USER_ACCESS_TOKEN = o.randomString(10);
        let t = new f(e);
        window.fetch = t
    } catch (e) {
        console.log("catch err:" + e.message)
    }
}]);