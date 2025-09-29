function Wr(e,t){return function(){return e.apply(t,arguments)}}const{toString:ps}=Object.prototype,{getPrototypeOf:wn}=Object,ct=(e=>t=>{const n=ps.call(t);return e[n]||(e[n]=n.slice(8,-1).toLowerCase())})(Object.create(null)),$=e=>(e=e.toLowerCase(),t=>ct(t)===e),ut=e=>t=>typeof t===e,{isArray:_e}=Array,ke=ut("undefined");function hs(e){return e!==null&&!ke(e)&&e.constructor!==null&&!ke(e.constructor)&&P(e.constructor.isBuffer)&&e.constructor.isBuffer(e)}const Jr=$("ArrayBuffer");function gs(e){let t;return typeof ArrayBuffer<"u"&&ArrayBuffer.isView?t=ArrayBuffer.isView(e):t=e&&e.buffer&&Jr(e.buffer),t}const ms=ut("string"),P=ut("function"),Gr=ut("number"),lt=e=>e!==null&&typeof e=="object",bs=e=>e===!0||e===!1,Ge=e=>{if(ct(e)!=="object")return!1;const t=wn(e);return(t===null||t===Object.prototype||Object.getPrototypeOf(t)===null)&&!(Symbol.toStringTag in e)&&!(Symbol.iterator in e)},_s=$("Date"),ys=$("File"),ws=$("Blob"),Es=$("FileList"),Ss=e=>lt(e)&&P(e.pipe),As=e=>{let t;return e&&(typeof FormData=="function"&&e instanceof FormData||P(e.append)&&((t=ct(e))==="formdata"||t==="object"&&P(e.toString)&&e.toString()==="[object FormData]"))},vs=$("URLSearchParams"),[xs,Ts,Cs,Os]=["ReadableStream","Request","Response","Headers"].map($),Is=e=>e.trim?e.trim():e.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,"");function Le(e,t,{allOwnKeys:n=!1}={}){if(e===null||typeof e>"u")return;let r,i;if(typeof e!="object"&&(e=[e]),_e(e))for(r=0,i=e.length;r<i;r++)t.call(null,e[r],r,e);else{const o=n?Object.getOwnPropertyNames(e):Object.keys(e),s=o.length;let a;for(r=0;r<s;r++)a=o[r],t.call(null,e[a],a,e)}}function Xr(e,t){t=t.toLowerCase();const n=Object.keys(e);let r=n.length,i;for(;r-- >0;)if(i=n[r],t===i.toLowerCase())return i;return null}const te=typeof globalThis<"u"?globalThis:typeof self<"u"?self:typeof window<"u"?window:global,Yr=e=>!ke(e)&&e!==te;function qt(){const{caseless:e}=Yr(this)&&this||{},t={},n=(r,i)=>{const o=e&&Xr(t,i)||i;Ge(t[o])&&Ge(r)?t[o]=qt(t[o],r):Ge(r)?t[o]=qt({},r):_e(r)?t[o]=r.slice():t[o]=r};for(let r=0,i=arguments.length;r<i;r++)arguments[r]&&Le(arguments[r],n);return t}const Rs=(e,t,n,{allOwnKeys:r}={})=>(Le(t,(i,o)=>{n&&P(i)?e[o]=Wr(i,n):e[o]=i},{allOwnKeys:r}),e),Ds=e=>(e.charCodeAt(0)===65279&&(e=e.slice(1)),e),Ns=(e,t,n,r)=>{e.prototype=Object.create(t.prototype,r),e.prototype.constructor=e,Object.defineProperty(e,"super",{value:t.prototype}),n&&Object.assign(e.prototype,n)},ks=(e,t,n,r)=>{let i,o,s;const a={};if(t=t||{},e==null)return t;do{for(i=Object.getOwnPropertyNames(e),o=i.length;o-- >0;)s=i[o],(!r||r(s,e,t))&&!a[s]&&(t[s]=e[s],a[s]=!0);e=n!==!1&&wn(e)}while(e&&(!n||n(e,t))&&e!==Object.prototype);return t},Ps=(e,t,n)=>{e=String(e),(n===void 0||n>e.length)&&(n=e.length),n-=t.length;const r=e.indexOf(t,n);return r!==-1&&r===n},Ms=e=>{if(!e)return null;if(_e(e))return e;let t=e.length;if(!Gr(t))return null;const n=new Array(t);for(;t-- >0;)n[t]=e[t];return n},Bs=(e=>t=>e&&t instanceof e)(typeof Uint8Array<"u"&&wn(Uint8Array)),$s=(e,t)=>{const r=(e&&e[Symbol.iterator]).call(e);let i;for(;(i=r.next())&&!i.done;){const o=i.value;t.call(e,o[0],o[1])}},Ls=(e,t)=>{let n;const r=[];for(;(n=e.exec(t))!==null;)r.push(n);return r},Fs=$("HTMLFormElement"),js=e=>e.toLowerCase().replace(/[-_\s]([a-z\d])(\w*)/g,function(n,r,i){return r.toUpperCase()+i}),er=(({hasOwnProperty:e})=>(t,n)=>e.call(t,n))(Object.prototype),Hs=$("RegExp"),Qr=(e,t)=>{const n=Object.getOwnPropertyDescriptors(e),r={};Le(n,(i,o)=>{let s;(s=t(i,o,e))!==!1&&(r[o]=s||i)}),Object.defineProperties(e,r)},Us=e=>{Qr(e,(t,n)=>{if(P(e)&&["arguments","caller","callee"].indexOf(n)!==-1)return!1;const r=e[n];if(P(r)){if(t.enumerable=!1,"writable"in t){t.writable=!1;return}t.set||(t.set=()=>{throw Error("Can not rewrite read-only method '"+n+"'")})}})},qs=(e,t)=>{const n={},r=i=>{i.forEach(o=>{n[o]=!0})};return _e(e)?r(e):r(String(e).split(t)),n},Ks=()=>{},zs=(e,t)=>e!=null&&Number.isFinite(e=+e)?e:t;function Vs(e){return!!(e&&P(e.append)&&e[Symbol.toStringTag]==="FormData"&&e[Symbol.iterator])}const Ws=e=>{const t=new Array(10),n=(r,i)=>{if(lt(r)){if(t.indexOf(r)>=0)return;if(!("toJSON"in r)){t[i]=r;const o=_e(r)?[]:{};return Le(r,(s,a)=>{const c=n(s,i+1);!ke(c)&&(o[a]=c)}),t[i]=void 0,o}}return r};return n(e,0)},Js=$("AsyncFunction"),Gs=e=>e&&(lt(e)||P(e))&&P(e.then)&&P(e.catch),Zr=((e,t)=>e?setImmediate:t?((n,r)=>(te.addEventListener("message",({source:i,data:o})=>{i===te&&o===n&&r.length&&r.shift()()},!1),i=>{r.push(i),te.postMessage(n,"*")}))(`axios@${Math.random()}`,[]):n=>setTimeout(n))(typeof setImmediate=="function",P(te.postMessage)),Xs=typeof queueMicrotask<"u"?queueMicrotask.bind(te):typeof process<"u"&&process.nextTick||Zr,f={isArray:_e,isArrayBuffer:Jr,isBuffer:hs,isFormData:As,isArrayBufferView:gs,isString:ms,isNumber:Gr,isBoolean:bs,isObject:lt,isPlainObject:Ge,isReadableStream:xs,isRequest:Ts,isResponse:Cs,isHeaders:Os,isUndefined:ke,isDate:_s,isFile:ys,isBlob:ws,isRegExp:Hs,isFunction:P,isStream:Ss,isURLSearchParams:vs,isTypedArray:Bs,isFileList:Es,forEach:Le,merge:qt,extend:Rs,trim:Is,stripBOM:Ds,inherits:Ns,toFlatObject:ks,kindOf:ct,kindOfTest:$,endsWith:Ps,toArray:Ms,forEachEntry:$s,matchAll:Ls,isHTMLForm:Fs,hasOwnProperty:er,hasOwnProp:er,reduceDescriptors:Qr,freezeMethods:Us,toObjectSet:qs,toCamelCase:js,noop:Ks,toFiniteNumber:zs,findKey:Xr,global:te,isContextDefined:Yr,isSpecCompliantForm:Vs,toJSONObject:Ws,isAsyncFn:Js,isThenable:Gs,setImmediate:Zr,asap:Xs};function y(e,t,n,r,i){Error.call(this),Error.captureStackTrace?Error.captureStackTrace(this,this.constructor):this.stack=new Error().stack,this.message=e,this.name="AxiosError",t&&(this.code=t),n&&(this.config=n),r&&(this.request=r),i&&(this.response=i,this.status=i.status?i.status:null)}f.inherits(y,Error,{toJSON:function(){return{message:this.message,name:this.name,description:this.description,number:this.number,fileName:this.fileName,lineNumber:this.lineNumber,columnNumber:this.columnNumber,stack:this.stack,config:f.toJSONObject(this.config),code:this.code,status:this.status}}});const ei=y.prototype,ti={};["ERR_BAD_OPTION_VALUE","ERR_BAD_OPTION","ECONNABORTED","ETIMEDOUT","ERR_NETWORK","ERR_FR_TOO_MANY_REDIRECTS","ERR_DEPRECATED","ERR_BAD_RESPONSE","ERR_BAD_REQUEST","ERR_CANCELED","ERR_NOT_SUPPORT","ERR_INVALID_URL"].forEach(e=>{ti[e]={value:e}});Object.defineProperties(y,ti);Object.defineProperty(ei,"isAxiosError",{value:!0});y.from=(e,t,n,r,i,o)=>{const s=Object.create(ei);return f.toFlatObject(e,s,function(c){return c!==Error.prototype},a=>a!=="isAxiosError"),y.call(s,e.message,t,n,r,i),s.cause=e,s.name=e.name,o&&Object.assign(s,o),s};const Ys=null;function Kt(e){return f.isPlainObject(e)||f.isArray(e)}function ni(e){return f.endsWith(e,"[]")?e.slice(0,-2):e}function tr(e,t,n){return e?e.concat(t).map(function(i,o){return i=ni(i),!n&&o?"["+i+"]":i}).join(n?".":""):t}function Qs(e){return f.isArray(e)&&!e.some(Kt)}const Zs=f.toFlatObject(f,{},null,function(t){return/^is[A-Z]/.test(t)});function ft(e,t,n){if(!f.isObject(e))throw new TypeError("target must be an object");t=t||new FormData,n=f.toFlatObject(n,{metaTokens:!0,dots:!1,indexes:!1},!1,function(m,d){return!f.isUndefined(d[m])});const r=n.metaTokens,i=n.visitor||l,o=n.dots,s=n.indexes,c=(n.Blob||typeof Blob<"u"&&Blob)&&f.isSpecCompliantForm(t);if(!f.isFunction(i))throw new TypeError("visitor must be a function");function u(g){if(g===null)return"";if(f.isDate(g))return g.toISOString();if(!c&&f.isBlob(g))throw new y("Blob is not supported. Use a Buffer instead.");return f.isArrayBuffer(g)||f.isTypedArray(g)?c&&typeof Blob=="function"?new Blob([g]):Buffer.from(g):g}function l(g,m,d){let _=g;if(g&&!d&&typeof g=="object"){if(f.endsWith(m,"{}"))m=r?m:m.slice(0,-2),g=JSON.stringify(g);else if(f.isArray(g)&&Qs(g)||(f.isFileList(g)||f.endsWith(m,"[]"))&&(_=f.toArray(g)))return m=ni(m),_.forEach(function(E,x){!(f.isUndefined(E)||E===null)&&t.append(s===!0?tr([m],x,o):s===null?m:m+"[]",u(E))}),!1}return Kt(g)?!0:(t.append(tr(d,m,o),u(g)),!1)}const p=[],h=Object.assign(Zs,{defaultVisitor:l,convertValue:u,isVisitable:Kt});function b(g,m){if(!f.isUndefined(g)){if(p.indexOf(g)!==-1)throw Error("Circular reference detected in "+m.join("."));p.push(g),f.forEach(g,function(_,w){(!(f.isUndefined(_)||_===null)&&i.call(t,_,f.isString(w)?w.trim():w,m,h))===!0&&b(_,m?m.concat(w):[w])}),p.pop()}}if(!f.isObject(e))throw new TypeError("data must be an object");return b(e),t}function nr(e){const t={"!":"%21","'":"%27","(":"%28",")":"%29","~":"%7E","%20":"+","%00":"\0"};return encodeURIComponent(e).replace(/[!'()~]|%20|%00/g,function(r){return t[r]})}function En(e,t){this._pairs=[],e&&ft(e,this,t)}const ri=En.prototype;ri.append=function(t,n){this._pairs.push([t,n])};ri.toString=function(t){const n=t?function(r){return t.call(this,r,nr)}:nr;return this._pairs.map(function(i){return n(i[0])+"="+n(i[1])},"").join("&")};function ea(e){return encodeURIComponent(e).replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}function ii(e,t,n){if(!t)return e;const r=n&&n.encode||ea;f.isFunction(n)&&(n={serialize:n});const i=n&&n.serialize;let o;if(i?o=i(t,n):o=f.isURLSearchParams(t)?t.toString():new En(t,n).toString(r),o){const s=e.indexOf("#");s!==-1&&(e=e.slice(0,s)),e+=(e.indexOf("?")===-1?"?":"&")+o}return e}class rr{constructor(){this.handlers=[]}use(t,n,r){return this.handlers.push({fulfilled:t,rejected:n,synchronous:r?r.synchronous:!1,runWhen:r?r.runWhen:null}),this.handlers.length-1}eject(t){this.handlers[t]&&(this.handlers[t]=null)}clear(){this.handlers&&(this.handlers=[])}forEach(t){f.forEach(this.handlers,function(r){r!==null&&t(r)})}}const oi={silentJSONParsing:!0,forcedJSONParsing:!0,clarifyTimeoutError:!1},ta=typeof URLSearchParams<"u"?URLSearchParams:En,na=typeof FormData<"u"?FormData:null,ra=typeof Blob<"u"?Blob:null,ia={isBrowser:!0,classes:{URLSearchParams:ta,FormData:na,Blob:ra},protocols:["http","https","file","blob","url","data"]},Sn=typeof window<"u"&&typeof document<"u",zt=typeof navigator=="object"&&navigator||void 0,oa=Sn&&(!zt||["ReactNative","NativeScript","NS"].indexOf(zt.product)<0),sa=typeof WorkerGlobalScope<"u"&&self instanceof WorkerGlobalScope&&typeof self.importScripts=="function",aa=Sn&&window.location.href||"http://localhost",ca=Object.freeze(Object.defineProperty({__proto__:null,hasBrowserEnv:Sn,hasStandardBrowserEnv:oa,hasStandardBrowserWebWorkerEnv:sa,navigator:zt,origin:aa},Symbol.toStringTag,{value:"Module"})),I={...ca,...ia};function ua(e,t){return ft(e,new I.classes.URLSearchParams,Object.assign({visitor:function(n,r,i,o){return I.isNode&&f.isBuffer(n)?(this.append(r,n.toString("base64")),!1):o.defaultVisitor.apply(this,arguments)}},t))}function la(e){return f.matchAll(/\w+|\[(\w*)]/g,e).map(t=>t[0]==="[]"?"":t[1]||t[0])}function fa(e){const t={},n=Object.keys(e);let r;const i=n.length;let o;for(r=0;r<i;r++)o=n[r],t[o]=e[o];return t}function si(e){function t(n,r,i,o){let s=n[o++];if(s==="__proto__")return!0;const a=Number.isFinite(+s),c=o>=n.length;return s=!s&&f.isArray(i)?i.length:s,c?(f.hasOwnProp(i,s)?i[s]=[i[s],r]:i[s]=r,!a):((!i[s]||!f.isObject(i[s]))&&(i[s]=[]),t(n,r,i[s],o)&&f.isArray(i[s])&&(i[s]=fa(i[s])),!a)}if(f.isFormData(e)&&f.isFunction(e.entries)){const n={};return f.forEachEntry(e,(r,i)=>{t(la(r),i,n,0)}),n}return null}function da(e,t,n){if(f.isString(e))try{return(t||JSON.parse)(e),f.trim(e)}catch(r){if(r.name!=="SyntaxError")throw r}return(n||JSON.stringify)(e)}const Fe={transitional:oi,adapter:["xhr","http","fetch"],transformRequest:[function(t,n){const r=n.getContentType()||"",i=r.indexOf("application/json")>-1,o=f.isObject(t);if(o&&f.isHTMLForm(t)&&(t=new FormData(t)),f.isFormData(t))return i?JSON.stringify(si(t)):t;if(f.isArrayBuffer(t)||f.isBuffer(t)||f.isStream(t)||f.isFile(t)||f.isBlob(t)||f.isReadableStream(t))return t;if(f.isArrayBufferView(t))return t.buffer;if(f.isURLSearchParams(t))return n.setContentType("application/x-www-form-urlencoded;charset=utf-8",!1),t.toString();let a;if(o){if(r.indexOf("application/x-www-form-urlencoded")>-1)return ua(t,this.formSerializer).toString();if((a=f.isFileList(t))||r.indexOf("multipart/form-data")>-1){const c=this.env&&this.env.FormData;return ft(a?{"files[]":t}:t,c&&new c,this.formSerializer)}}return o||i?(n.setContentType("application/json",!1),da(t)):t}],transformResponse:[function(t){const n=this.transitional||Fe.transitional,r=n&&n.forcedJSONParsing,i=this.responseType==="json";if(f.isResponse(t)||f.isReadableStream(t))return t;if(t&&f.isString(t)&&(r&&!this.responseType||i)){const s=!(n&&n.silentJSONParsing)&&i;try{return JSON.parse(t)}catch(a){if(s)throw a.name==="SyntaxError"?y.from(a,y.ERR_BAD_RESPONSE,this,null,this.response):a}}return t}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,maxBodyLength:-1,env:{FormData:I.classes.FormData,Blob:I.classes.Blob},validateStatus:function(t){return t>=200&&t<300},headers:{common:{Accept:"application/json, text/plain, */*","Content-Type":void 0}}};f.forEach(["delete","get","head","post","put","patch"],e=>{Fe.headers[e]={}});const pa=f.toObjectSet(["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"]),ha=e=>{const t={};let n,r,i;return e&&e.split(`
`).forEach(function(s){i=s.indexOf(":"),n=s.substring(0,i).trim().toLowerCase(),r=s.substring(i+1).trim(),!(!n||t[n]&&pa[n])&&(n==="set-cookie"?t[n]?t[n].push(r):t[n]=[r]:t[n]=t[n]?t[n]+", "+r:r)}),t},ir=Symbol("internals");function Te(e){return e&&String(e).trim().toLowerCase()}function Xe(e){return e===!1||e==null?e:f.isArray(e)?e.map(Xe):String(e)}function ga(e){const t=Object.create(null),n=/([^\s,;=]+)\s*(?:=\s*([^,;]+))?/g;let r;for(;r=n.exec(e);)t[r[1]]=r[2];return t}const ma=e=>/^[-_a-zA-Z0-9^`|~,!#$%&'*+.]+$/.test(e.trim());function xt(e,t,n,r,i){if(f.isFunction(r))return r.call(this,t,n);if(i&&(t=n),!!f.isString(t)){if(f.isString(r))return t.indexOf(r)!==-1;if(f.isRegExp(r))return r.test(t)}}function ba(e){return e.trim().toLowerCase().replace(/([a-z\d])(\w*)/g,(t,n,r)=>n.toUpperCase()+r)}function _a(e,t){const n=f.toCamelCase(" "+t);["get","set","has"].forEach(r=>{Object.defineProperty(e,r+n,{value:function(i,o,s){return this[r].call(this,t,i,o,s)},configurable:!0})})}let k=class{constructor(t){t&&this.set(t)}set(t,n,r){const i=this;function o(a,c,u){const l=Te(c);if(!l)throw new Error("header name must be a non-empty string");const p=f.findKey(i,l);(!p||i[p]===void 0||u===!0||u===void 0&&i[p]!==!1)&&(i[p||c]=Xe(a))}const s=(a,c)=>f.forEach(a,(u,l)=>o(u,l,c));if(f.isPlainObject(t)||t instanceof this.constructor)s(t,n);else if(f.isString(t)&&(t=t.trim())&&!ma(t))s(ha(t),n);else if(f.isHeaders(t))for(const[a,c]of t.entries())o(c,a,r);else t!=null&&o(n,t,r);return this}get(t,n){if(t=Te(t),t){const r=f.findKey(this,t);if(r){const i=this[r];if(!n)return i;if(n===!0)return ga(i);if(f.isFunction(n))return n.call(this,i,r);if(f.isRegExp(n))return n.exec(i);throw new TypeError("parser must be boolean|regexp|function")}}}has(t,n){if(t=Te(t),t){const r=f.findKey(this,t);return!!(r&&this[r]!==void 0&&(!n||xt(this,this[r],r,n)))}return!1}delete(t,n){const r=this;let i=!1;function o(s){if(s=Te(s),s){const a=f.findKey(r,s);a&&(!n||xt(r,r[a],a,n))&&(delete r[a],i=!0)}}return f.isArray(t)?t.forEach(o):o(t),i}clear(t){const n=Object.keys(this);let r=n.length,i=!1;for(;r--;){const o=n[r];(!t||xt(this,this[o],o,t,!0))&&(delete this[o],i=!0)}return i}normalize(t){const n=this,r={};return f.forEach(this,(i,o)=>{const s=f.findKey(r,o);if(s){n[s]=Xe(i),delete n[o];return}const a=t?ba(o):String(o).trim();a!==o&&delete n[o],n[a]=Xe(i),r[a]=!0}),this}concat(...t){return this.constructor.concat(this,...t)}toJSON(t){const n=Object.create(null);return f.forEach(this,(r,i)=>{r!=null&&r!==!1&&(n[i]=t&&f.isArray(r)?r.join(", "):r)}),n}[Symbol.iterator](){return Object.entries(this.toJSON())[Symbol.iterator]()}toString(){return Object.entries(this.toJSON()).map(([t,n])=>t+": "+n).join(`
`)}get[Symbol.toStringTag](){return"AxiosHeaders"}static from(t){return t instanceof this?t:new this(t)}static concat(t,...n){const r=new this(t);return n.forEach(i=>r.set(i)),r}static accessor(t){const r=(this[ir]=this[ir]={accessors:{}}).accessors,i=this.prototype;function o(s){const a=Te(s);r[a]||(_a(i,s),r[a]=!0)}return f.isArray(t)?t.forEach(o):o(t),this}};k.accessor(["Content-Type","Content-Length","Accept","Accept-Encoding","User-Agent","Authorization"]);f.reduceDescriptors(k.prototype,({value:e},t)=>{let n=t[0].toUpperCase()+t.slice(1);return{get:()=>e,set(r){this[n]=r}}});f.freezeMethods(k);function Tt(e,t){const n=this||Fe,r=t||n,i=k.from(r.headers);let o=r.data;return f.forEach(e,function(a){o=a.call(n,o,i.normalize(),t?t.status:void 0)}),i.normalize(),o}function ai(e){return!!(e&&e.__CANCEL__)}function ye(e,t,n){y.call(this,e??"canceled",y.ERR_CANCELED,t,n),this.name="CanceledError"}f.inherits(ye,y,{__CANCEL__:!0});function ci(e,t,n){const r=n.config.validateStatus;!n.status||!r||r(n.status)?e(n):t(new y("Request failed with status code "+n.status,[y.ERR_BAD_REQUEST,y.ERR_BAD_RESPONSE][Math.floor(n.status/100)-4],n.config,n.request,n))}function ya(e){const t=/^([-+\w]{1,25})(:?\/\/|:)/.exec(e);return t&&t[1]||""}function wa(e,t){e=e||10;const n=new Array(e),r=new Array(e);let i=0,o=0,s;return t=t!==void 0?t:1e3,function(c){const u=Date.now(),l=r[o];s||(s=u),n[i]=c,r[i]=u;let p=o,h=0;for(;p!==i;)h+=n[p++],p=p%e;if(i=(i+1)%e,i===o&&(o=(o+1)%e),u-s<t)return;const b=l&&u-l;return b?Math.round(h*1e3/b):void 0}}function Ea(e,t){let n=0,r=1e3/t,i,o;const s=(u,l=Date.now())=>{n=l,i=null,o&&(clearTimeout(o),o=null),e.apply(null,u)};return[(...u)=>{const l=Date.now(),p=l-n;p>=r?s(u,l):(i=u,o||(o=setTimeout(()=>{o=null,s(i)},r-p)))},()=>i&&s(i)]}const et=(e,t,n=3)=>{let r=0;const i=wa(50,250);return Ea(o=>{const s=o.loaded,a=o.lengthComputable?o.total:void 0,c=s-r,u=i(c),l=s<=a;r=s;const p={loaded:s,total:a,progress:a?s/a:void 0,bytes:c,rate:u||void 0,estimated:u&&a&&l?(a-s)/u:void 0,event:o,lengthComputable:a!=null,[t?"download":"upload"]:!0};e(p)},n)},or=(e,t)=>{const n=e!=null;return[r=>t[0]({lengthComputable:n,total:e,loaded:r}),t[1]]},sr=e=>(...t)=>f.asap(()=>e(...t)),Sa=I.hasStandardBrowserEnv?((e,t)=>n=>(n=new URL(n,I.origin),e.protocol===n.protocol&&e.host===n.host&&(t||e.port===n.port)))(new URL(I.origin),I.navigator&&/(msie|trident)/i.test(I.navigator.userAgent)):()=>!0,Aa=I.hasStandardBrowserEnv?{write(e,t,n,r,i,o){const s=[e+"="+encodeURIComponent(t)];f.isNumber(n)&&s.push("expires="+new Date(n).toGMTString()),f.isString(r)&&s.push("path="+r),f.isString(i)&&s.push("domain="+i),o===!0&&s.push("secure"),document.cookie=s.join("; ")},read(e){const t=document.cookie.match(new RegExp("(^|;\\s*)("+e+")=([^;]*)"));return t?decodeURIComponent(t[3]):null},remove(e){this.write(e,"",Date.now()-864e5)}}:{write(){},read(){return null},remove(){}};function va(e){return/^([a-z][a-z\d+\-.]*:)?\/\//i.test(e)}function xa(e,t){return t?e.replace(/\/?\/$/,"")+"/"+t.replace(/^\/+/,""):e}function ui(e,t,n){let r=!va(t);return e&&(r||n==!1)?xa(e,t):t}const ar=e=>e instanceof k?{...e}:e;function ue(e,t){t=t||{};const n={};function r(u,l,p,h){return f.isPlainObject(u)&&f.isPlainObject(l)?f.merge.call({caseless:h},u,l):f.isPlainObject(l)?f.merge({},l):f.isArray(l)?l.slice():l}function i(u,l,p,h){if(f.isUndefined(l)){if(!f.isUndefined(u))return r(void 0,u,p,h)}else return r(u,l,p,h)}function o(u,l){if(!f.isUndefined(l))return r(void 0,l)}function s(u,l){if(f.isUndefined(l)){if(!f.isUndefined(u))return r(void 0,u)}else return r(void 0,l)}function a(u,l,p){if(p in t)return r(u,l);if(p in e)return r(void 0,u)}const c={url:o,method:o,data:o,baseURL:s,transformRequest:s,transformResponse:s,paramsSerializer:s,timeout:s,timeoutMessage:s,withCredentials:s,withXSRFToken:s,adapter:s,responseType:s,xsrfCookieName:s,xsrfHeaderName:s,onUploadProgress:s,onDownloadProgress:s,decompress:s,maxContentLength:s,maxBodyLength:s,beforeRedirect:s,transport:s,httpAgent:s,httpsAgent:s,cancelToken:s,socketPath:s,responseEncoding:s,validateStatus:a,headers:(u,l,p)=>i(ar(u),ar(l),p,!0)};return f.forEach(Object.keys(Object.assign({},e,t)),function(l){const p=c[l]||i,h=p(e[l],t[l],l);f.isUndefined(h)&&p!==a||(n[l]=h)}),n}const li=e=>{const t=ue({},e);let{data:n,withXSRFToken:r,xsrfHeaderName:i,xsrfCookieName:o,headers:s,auth:a}=t;t.headers=s=k.from(s),t.url=ii(ui(t.baseURL,t.url,t.allowAbsoluteUrls),e.params,e.paramsSerializer),a&&s.set("Authorization","Basic "+btoa((a.username||"")+":"+(a.password?unescape(encodeURIComponent(a.password)):"")));let c;if(f.isFormData(n)){if(I.hasStandardBrowserEnv||I.hasStandardBrowserWebWorkerEnv)s.setContentType(void 0);else if((c=s.getContentType())!==!1){const[u,...l]=c?c.split(";").map(p=>p.trim()).filter(Boolean):[];s.setContentType([u||"multipart/form-data",...l].join("; "))}}if(I.hasStandardBrowserEnv&&(r&&f.isFunction(r)&&(r=r(t)),r||r!==!1&&Sa(t.url))){const u=i&&o&&Aa.read(o);u&&s.set(i,u)}return t},Ta=typeof XMLHttpRequest<"u",Ca=Ta&&function(e){return new Promise(function(n,r){const i=li(e);let o=i.data;const s=k.from(i.headers).normalize();let{responseType:a,onUploadProgress:c,onDownloadProgress:u}=i,l,p,h,b,g;function m(){b&&b(),g&&g(),i.cancelToken&&i.cancelToken.unsubscribe(l),i.signal&&i.signal.removeEventListener("abort",l)}let d=new XMLHttpRequest;d.open(i.method.toUpperCase(),i.url,!0),d.timeout=i.timeout;function _(){if(!d)return;const E=k.from("getAllResponseHeaders"in d&&d.getAllResponseHeaders()),T={data:!a||a==="text"||a==="json"?d.responseText:d.response,status:d.status,statusText:d.statusText,headers:E,config:e,request:d};ci(function(F){n(F),m()},function(F){r(F),m()},T),d=null}"onloadend"in d?d.onloadend=_:d.onreadystatechange=function(){!d||d.readyState!==4||d.status===0&&!(d.responseURL&&d.responseURL.indexOf("file:")===0)||setTimeout(_)},d.onabort=function(){d&&(r(new y("Request aborted",y.ECONNABORTED,e,d)),d=null)},d.onerror=function(){r(new y("Network Error",y.ERR_NETWORK,e,d)),d=null},d.ontimeout=function(){let x=i.timeout?"timeout of "+i.timeout+"ms exceeded":"timeout exceeded";const T=i.transitional||oi;i.timeoutErrorMessage&&(x=i.timeoutErrorMessage),r(new y(x,T.clarifyTimeoutError?y.ETIMEDOUT:y.ECONNABORTED,e,d)),d=null},o===void 0&&s.setContentType(null),"setRequestHeader"in d&&f.forEach(s.toJSON(),function(x,T){d.setRequestHeader(T,x)}),f.isUndefined(i.withCredentials)||(d.withCredentials=!!i.withCredentials),a&&a!=="json"&&(d.responseType=i.responseType),u&&([h,g]=et(u,!0),d.addEventListener("progress",h)),c&&d.upload&&([p,b]=et(c),d.upload.addEventListener("progress",p),d.upload.addEventListener("loadend",b)),(i.cancelToken||i.signal)&&(l=E=>{d&&(r(!E||E.type?new ye(null,e,d):E),d.abort(),d=null)},i.cancelToken&&i.cancelToken.subscribe(l),i.signal&&(i.signal.aborted?l():i.signal.addEventListener("abort",l)));const w=ya(i.url);if(w&&I.protocols.indexOf(w)===-1){r(new y("Unsupported protocol "+w+":",y.ERR_BAD_REQUEST,e));return}d.send(o||null)})},Oa=(e,t)=>{const{length:n}=e=e?e.filter(Boolean):[];if(t||n){let r=new AbortController,i;const o=function(u){if(!i){i=!0,a();const l=u instanceof Error?u:this.reason;r.abort(l instanceof y?l:new ye(l instanceof Error?l.message:l))}};let s=t&&setTimeout(()=>{s=null,o(new y(`timeout ${t} of ms exceeded`,y.ETIMEDOUT))},t);const a=()=>{e&&(s&&clearTimeout(s),s=null,e.forEach(u=>{u.unsubscribe?u.unsubscribe(o):u.removeEventListener("abort",o)}),e=null)};e.forEach(u=>u.addEventListener("abort",o));const{signal:c}=r;return c.unsubscribe=()=>f.asap(a),c}},Ia=function*(e,t){let n=e.byteLength;if(n<t){yield e;return}let r=0,i;for(;r<n;)i=r+t,yield e.slice(r,i),r=i},Ra=async function*(e,t){for await(const n of Da(e))yield*Ia(n,t)},Da=async function*(e){if(e[Symbol.asyncIterator]){yield*e;return}const t=e.getReader();try{for(;;){const{done:n,value:r}=await t.read();if(n)break;yield r}}finally{await t.cancel()}},cr=(e,t,n,r)=>{const i=Ra(e,t);let o=0,s,a=c=>{s||(s=!0,r&&r(c))};return new ReadableStream({async pull(c){try{const{done:u,value:l}=await i.next();if(u){a(),c.close();return}let p=l.byteLength;if(n){let h=o+=p;n(h)}c.enqueue(new Uint8Array(l))}catch(u){throw a(u),u}},cancel(c){return a(c),i.return()}},{highWaterMark:2})},dt=typeof fetch=="function"&&typeof Request=="function"&&typeof Response=="function",fi=dt&&typeof ReadableStream=="function",Na=dt&&(typeof TextEncoder=="function"?(e=>t=>e.encode(t))(new TextEncoder):async e=>new Uint8Array(await new Response(e).arrayBuffer())),di=(e,...t)=>{try{return!!e(...t)}catch{return!1}},ka=fi&&di(()=>{let e=!1;const t=new Request(I.origin,{body:new ReadableStream,method:"POST",get duplex(){return e=!0,"half"}}).headers.has("Content-Type");return e&&!t}),ur=64*1024,Vt=fi&&di(()=>f.isReadableStream(new Response("").body)),tt={stream:Vt&&(e=>e.body)};dt&&(e=>{["text","arrayBuffer","blob","formData","stream"].forEach(t=>{!tt[t]&&(tt[t]=f.isFunction(e[t])?n=>n[t]():(n,r)=>{throw new y(`Response type '${t}' is not supported`,y.ERR_NOT_SUPPORT,r)})})})(new Response);const Pa=async e=>{if(e==null)return 0;if(f.isBlob(e))return e.size;if(f.isSpecCompliantForm(e))return(await new Request(I.origin,{method:"POST",body:e}).arrayBuffer()).byteLength;if(f.isArrayBufferView(e)||f.isArrayBuffer(e))return e.byteLength;if(f.isURLSearchParams(e)&&(e=e+""),f.isString(e))return(await Na(e)).byteLength},Ma=async(e,t)=>{const n=f.toFiniteNumber(e.getContentLength());return n??Pa(t)},Ba=dt&&(async e=>{let{url:t,method:n,data:r,signal:i,cancelToken:o,timeout:s,onDownloadProgress:a,onUploadProgress:c,responseType:u,headers:l,withCredentials:p="same-origin",fetchOptions:h}=li(e);u=u?(u+"").toLowerCase():"text";let b=Oa([i,o&&o.toAbortSignal()],s),g;const m=b&&b.unsubscribe&&(()=>{b.unsubscribe()});let d;try{if(c&&ka&&n!=="get"&&n!=="head"&&(d=await Ma(l,r))!==0){let T=new Request(t,{method:"POST",body:r,duplex:"half"}),N;if(f.isFormData(r)&&(N=T.headers.get("content-type"))&&l.setContentType(N),T.body){const[F,ge]=or(d,et(sr(c)));r=cr(T.body,ur,F,ge)}}f.isString(p)||(p=p?"include":"omit");const _="credentials"in Request.prototype;g=new Request(t,{...h,signal:b,method:n.toUpperCase(),headers:l.normalize().toJSON(),body:r,duplex:"half",credentials:_?p:void 0});let w=await fetch(g);const E=Vt&&(u==="stream"||u==="response");if(Vt&&(a||E&&m)){const T={};["status","statusText","headers"].forEach(qe=>{T[qe]=w[qe]});const N=f.toFiniteNumber(w.headers.get("content-length")),[F,ge]=a&&or(N,et(sr(a),!0))||[];w=new Response(cr(w.body,ur,F,()=>{ge&&ge(),m&&m()}),T)}u=u||"text";let x=await tt[f.findKey(tt,u)||"text"](w,e);return!E&&m&&m(),await new Promise((T,N)=>{ci(T,N,{data:x,headers:k.from(w.headers),status:w.status,statusText:w.statusText,config:e,request:g})})}catch(_){throw m&&m(),_&&_.name==="TypeError"&&/fetch/i.test(_.message)?Object.assign(new y("Network Error",y.ERR_NETWORK,e,g),{cause:_.cause||_}):y.from(_,_&&_.code,e,g)}}),Wt={http:Ys,xhr:Ca,fetch:Ba};f.forEach(Wt,(e,t)=>{if(e){try{Object.defineProperty(e,"name",{value:t})}catch{}Object.defineProperty(e,"adapterName",{value:t})}});const lr=e=>`- ${e}`,$a=e=>f.isFunction(e)||e===null||e===!1,pi={getAdapter:e=>{e=f.isArray(e)?e:[e];const{length:t}=e;let n,r;const i={};for(let o=0;o<t;o++){n=e[o];let s;if(r=n,!$a(n)&&(r=Wt[(s=String(n)).toLowerCase()],r===void 0))throw new y(`Unknown adapter '${s}'`);if(r)break;i[s||"#"+o]=r}if(!r){const o=Object.entries(i).map(([a,c])=>`adapter ${a} `+(c===!1?"is not supported by the environment":"is not available in the build"));let s=t?o.length>1?`since :
`+o.map(lr).join(`
`):" "+lr(o[0]):"as no adapter specified";throw new y("There is no suitable adapter to dispatch the request "+s,"ERR_NOT_SUPPORT")}return r},adapters:Wt};function Ct(e){if(e.cancelToken&&e.cancelToken.throwIfRequested(),e.signal&&e.signal.aborted)throw new ye(null,e)}function fr(e){return Ct(e),e.headers=k.from(e.headers),e.data=Tt.call(e,e.transformRequest),["post","put","patch"].indexOf(e.method)!==-1&&e.headers.setContentType("application/x-www-form-urlencoded",!1),pi.getAdapter(e.adapter||Fe.adapter)(e).then(function(r){return Ct(e),r.data=Tt.call(e,e.transformResponse,r),r.headers=k.from(r.headers),r},function(r){return ai(r)||(Ct(e),r&&r.response&&(r.response.data=Tt.call(e,e.transformResponse,r.response),r.response.headers=k.from(r.response.headers))),Promise.reject(r)})}const hi="1.8.4",pt={};["object","boolean","number","function","string","symbol"].forEach((e,t)=>{pt[e]=function(r){return typeof r===e||"a"+(t<1?"n ":" ")+e}});const dr={};pt.transitional=function(t,n,r){function i(o,s){return"[Axios v"+hi+"] Transitional option '"+o+"'"+s+(r?". "+r:"")}return(o,s,a)=>{if(t===!1)throw new y(i(s," has been removed"+(n?" in "+n:"")),y.ERR_DEPRECATED);return n&&!dr[s]&&(dr[s]=!0,console.warn(i(s," has been deprecated since v"+n+" and will be removed in the near future"))),t?t(o,s,a):!0}};pt.spelling=function(t){return(n,r)=>(console.warn(`${r} is likely a misspelling of ${t}`),!0)};function La(e,t,n){if(typeof e!="object")throw new y("options must be an object",y.ERR_BAD_OPTION_VALUE);const r=Object.keys(e);let i=r.length;for(;i-- >0;){const o=r[i],s=t[o];if(s){const a=e[o],c=a===void 0||s(a,o,e);if(c!==!0)throw new y("option "+o+" must be "+c,y.ERR_BAD_OPTION_VALUE);continue}if(n!==!0)throw new y("Unknown option "+o,y.ERR_BAD_OPTION)}}const Ye={assertOptions:La,validators:pt},j=Ye.validators;let ie=class{constructor(t){this.defaults=t,this.interceptors={request:new rr,response:new rr}}async request(t,n){try{return await this._request(t,n)}catch(r){if(r instanceof Error){let i={};Error.captureStackTrace?Error.captureStackTrace(i):i=new Error;const o=i.stack?i.stack.replace(/^.+\n/,""):"";try{r.stack?o&&!String(r.stack).endsWith(o.replace(/^.+\n.+\n/,""))&&(r.stack+=`
`+o):r.stack=o}catch{}}throw r}}_request(t,n){typeof t=="string"?(n=n||{},n.url=t):n=t||{},n=ue(this.defaults,n);const{transitional:r,paramsSerializer:i,headers:o}=n;r!==void 0&&Ye.assertOptions(r,{silentJSONParsing:j.transitional(j.boolean),forcedJSONParsing:j.transitional(j.boolean),clarifyTimeoutError:j.transitional(j.boolean)},!1),i!=null&&(f.isFunction(i)?n.paramsSerializer={serialize:i}:Ye.assertOptions(i,{encode:j.function,serialize:j.function},!0)),n.allowAbsoluteUrls!==void 0||(this.defaults.allowAbsoluteUrls!==void 0?n.allowAbsoluteUrls=this.defaults.allowAbsoluteUrls:n.allowAbsoluteUrls=!0),Ye.assertOptions(n,{baseUrl:j.spelling("baseURL"),withXsrfToken:j.spelling("withXSRFToken")},!0),n.method=(n.method||this.defaults.method||"get").toLowerCase();let s=o&&f.merge(o.common,o[n.method]);o&&f.forEach(["delete","get","head","post","put","patch","common"],g=>{delete o[g]}),n.headers=k.concat(s,o);const a=[];let c=!0;this.interceptors.request.forEach(function(m){typeof m.runWhen=="function"&&m.runWhen(n)===!1||(c=c&&m.synchronous,a.unshift(m.fulfilled,m.rejected))});const u=[];this.interceptors.response.forEach(function(m){u.push(m.fulfilled,m.rejected)});let l,p=0,h;if(!c){const g=[fr.bind(this),void 0];for(g.unshift.apply(g,a),g.push.apply(g,u),h=g.length,l=Promise.resolve(n);p<h;)l=l.then(g[p++],g[p++]);return l}h=a.length;let b=n;for(p=0;p<h;){const g=a[p++],m=a[p++];try{b=g(b)}catch(d){m.call(this,d);break}}try{l=fr.call(this,b)}catch(g){return Promise.reject(g)}for(p=0,h=u.length;p<h;)l=l.then(u[p++],u[p++]);return l}getUri(t){t=ue(this.defaults,t);const n=ui(t.baseURL,t.url,t.allowAbsoluteUrls);return ii(n,t.params,t.paramsSerializer)}};f.forEach(["delete","get","head","options"],function(t){ie.prototype[t]=function(n,r){return this.request(ue(r||{},{method:t,url:n,data:(r||{}).data}))}});f.forEach(["post","put","patch"],function(t){function n(r){return function(o,s,a){return this.request(ue(a||{},{method:t,headers:r?{"Content-Type":"multipart/form-data"}:{},url:o,data:s}))}}ie.prototype[t]=n(),ie.prototype[t+"Form"]=n(!0)});let Fa=class gi{constructor(t){if(typeof t!="function")throw new TypeError("executor must be a function.");let n;this.promise=new Promise(function(o){n=o});const r=this;this.promise.then(i=>{if(!r._listeners)return;let o=r._listeners.length;for(;o-- >0;)r._listeners[o](i);r._listeners=null}),this.promise.then=i=>{let o;const s=new Promise(a=>{r.subscribe(a),o=a}).then(i);return s.cancel=function(){r.unsubscribe(o)},s},t(function(o,s,a){r.reason||(r.reason=new ye(o,s,a),n(r.reason))})}throwIfRequested(){if(this.reason)throw this.reason}subscribe(t){if(this.reason){t(this.reason);return}this._listeners?this._listeners.push(t):this._listeners=[t]}unsubscribe(t){if(!this._listeners)return;const n=this._listeners.indexOf(t);n!==-1&&this._listeners.splice(n,1)}toAbortSignal(){const t=new AbortController,n=r=>{t.abort(r)};return this.subscribe(n),t.signal.unsubscribe=()=>this.unsubscribe(n),t.signal}static source(){let t;return{token:new gi(function(i){t=i}),cancel:t}}};function ja(e){return function(n){return e.apply(null,n)}}function Ha(e){return f.isObject(e)&&e.isAxiosError===!0}const Jt={Continue:100,SwitchingProtocols:101,Processing:102,EarlyHints:103,Ok:200,Created:201,Accepted:202,NonAuthoritativeInformation:203,NoContent:204,ResetContent:205,PartialContent:206,MultiStatus:207,AlreadyReported:208,ImUsed:226,MultipleChoices:300,MovedPermanently:301,Found:302,SeeOther:303,NotModified:304,UseProxy:305,Unused:306,TemporaryRedirect:307,PermanentRedirect:308,BadRequest:400,Unauthorized:401,PaymentRequired:402,Forbidden:403,NotFound:404,MethodNotAllowed:405,NotAcceptable:406,ProxyAuthenticationRequired:407,RequestTimeout:408,Conflict:409,Gone:410,LengthRequired:411,PreconditionFailed:412,PayloadTooLarge:413,UriTooLong:414,UnsupportedMediaType:415,RangeNotSatisfiable:416,ExpectationFailed:417,ImATeapot:418,MisdirectedRequest:421,UnprocessableEntity:422,Locked:423,FailedDependency:424,TooEarly:425,UpgradeRequired:426,PreconditionRequired:428,TooManyRequests:429,RequestHeaderFieldsTooLarge:431,UnavailableForLegalReasons:451,InternalServerError:500,NotImplemented:501,BadGateway:502,ServiceUnavailable:503,GatewayTimeout:504,HttpVersionNotSupported:505,VariantAlsoNegotiates:506,InsufficientStorage:507,LoopDetected:508,NotExtended:510,NetworkAuthenticationRequired:511};Object.entries(Jt).forEach(([e,t])=>{Jt[t]=e});function mi(e){const t=new ie(e),n=Wr(ie.prototype.request,t);return f.extend(n,ie.prototype,t,{allOwnKeys:!0}),f.extend(n,t,null,{allOwnKeys:!0}),n.create=function(i){return mi(ue(e,i))},n}const C=mi(Fe);C.Axios=ie;C.CanceledError=ye;C.CancelToken=Fa;C.isCancel=ai;C.VERSION=hi;C.toFormData=ft;C.AxiosError=y;C.Cancel=C.CanceledError;C.all=function(t){return Promise.all(t)};C.spread=ja;C.isAxiosError=Ha;C.mergeConfig=ue;C.AxiosHeaders=k;C.formToJSON=e=>si(f.isHTMLForm(e)?new FormData(e):e);C.getAdapter=pi.getAdapter;C.HttpStatusCode=Jt;C.default=C;const{Axios:op,AxiosError:sp,CanceledError:ap,isCancel:cp,CancelToken:up,VERSION:lp,all:fp,Cancel:dp,isAxiosError:pp,spread:hp,toFormData:gp,AxiosHeaders:mp,HttpStatusCode:bp,formToJSON:_p,getAdapter:yp,mergeConfig:wp}=C;window.axios=C;window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var Gt=!1,Xt=!1,oe=[],Yt=-1;function Ua(e){qa(e)}function qa(e){oe.includes(e)||oe.push(e),za()}function Ka(e){let t=oe.indexOf(e);t!==-1&&t>Yt&&oe.splice(t,1)}function za(){!Xt&&!Gt&&(Gt=!0,queueMicrotask(Va))}function Va(){Gt=!1,Xt=!0;for(let e=0;e<oe.length;e++)oe[e](),Yt=e;oe.length=0,Yt=-1,Xt=!1}var we,he,Ee,bi,Qt=!0;function Wa(e){Qt=!1,e(),Qt=!0}function Ja(e){we=e.reactive,Ee=e.release,he=t=>e.effect(t,{scheduler:n=>{Qt?Ua(n):n()}}),bi=e.raw}function pr(e){he=e}function Ga(e){let t=()=>{};return[r=>{let i=he(r);return e._x_effects||(e._x_effects=new Set,e._x_runEffects=()=>{e._x_effects.forEach(o=>o())}),e._x_effects.add(i),t=()=>{i!==void 0&&(e._x_effects.delete(i),Ee(i))},i},()=>{t()}]}function _i(e,t){let n=!0,r,i=he(()=>{let o=e();JSON.stringify(o),n?r=o:queueMicrotask(()=>{t(o,r),r=o}),n=!1});return()=>Ee(i)}var yi=[],wi=[],Ei=[];function Xa(e){Ei.push(e)}function An(e,t){typeof t=="function"?(e._x_cleanups||(e._x_cleanups=[]),e._x_cleanups.push(t)):(t=e,wi.push(t))}function Si(e){yi.push(e)}function Ai(e,t,n){e._x_attributeCleanups||(e._x_attributeCleanups={}),e._x_attributeCleanups[t]||(e._x_attributeCleanups[t]=[]),e._x_attributeCleanups[t].push(n)}function vi(e,t){e._x_attributeCleanups&&Object.entries(e._x_attributeCleanups).forEach(([n,r])=>{(t===void 0||t.includes(n))&&(r.forEach(i=>i()),delete e._x_attributeCleanups[n])})}function Ya(e){var t,n;for((t=e._x_effects)==null||t.forEach(Ka);(n=e._x_cleanups)!=null&&n.length;)e._x_cleanups.pop()()}var vn=new MutationObserver(On),xn=!1;function Tn(){vn.observe(document,{subtree:!0,childList:!0,attributes:!0,attributeOldValue:!0}),xn=!0}function xi(){Qa(),vn.disconnect(),xn=!1}var Ce=[];function Qa(){let e=vn.takeRecords();Ce.push(()=>e.length>0&&On(e));let t=Ce.length;queueMicrotask(()=>{if(Ce.length===t)for(;Ce.length>0;)Ce.shift()()})}function v(e){if(!xn)return e();xi();let t=e();return Tn(),t}var Cn=!1,nt=[];function Za(){Cn=!0}function ec(){Cn=!1,On(nt),nt=[]}function On(e){if(Cn){nt=nt.concat(e);return}let t=[],n=new Set,r=new Map,i=new Map;for(let o=0;o<e.length;o++)if(!e[o].target._x_ignoreMutationObserver&&(e[o].type==="childList"&&(e[o].removedNodes.forEach(s=>{s.nodeType===1&&s._x_marker&&n.add(s)}),e[o].addedNodes.forEach(s=>{if(s.nodeType===1){if(n.has(s)){n.delete(s);return}s._x_marker||t.push(s)}})),e[o].type==="attributes")){let s=e[o].target,a=e[o].attributeName,c=e[o].oldValue,u=()=>{r.has(s)||r.set(s,[]),r.get(s).push({name:a,value:s.getAttribute(a)})},l=()=>{i.has(s)||i.set(s,[]),i.get(s).push(a)};s.hasAttribute(a)&&c===null?u():s.hasAttribute(a)?(l(),u()):l()}i.forEach((o,s)=>{vi(s,o)}),r.forEach((o,s)=>{yi.forEach(a=>a(s,o))});for(let o of n)t.some(s=>s.contains(o))||wi.forEach(s=>s(o));for(let o of t)o.isConnected&&Ei.forEach(s=>s(o));t=null,n=null,r=null,i=null}function Ti(e){return He(me(e))}function je(e,t,n){return e._x_dataStack=[t,...me(n||e)],()=>{e._x_dataStack=e._x_dataStack.filter(r=>r!==t)}}function me(e){return e._x_dataStack?e._x_dataStack:typeof ShadowRoot=="function"&&e instanceof ShadowRoot?me(e.host):e.parentNode?me(e.parentNode):[]}function He(e){return new Proxy({objects:e},tc)}var tc={ownKeys({objects:e}){return Array.from(new Set(e.flatMap(t=>Object.keys(t))))},has({objects:e},t){return t==Symbol.unscopables?!1:e.some(n=>Object.prototype.hasOwnProperty.call(n,t)||Reflect.has(n,t))},get({objects:e},t,n){return t=="toJSON"?nc:Reflect.get(e.find(r=>Reflect.has(r,t))||{},t,n)},set({objects:e},t,n,r){const i=e.find(s=>Object.prototype.hasOwnProperty.call(s,t))||e[e.length-1],o=Object.getOwnPropertyDescriptor(i,t);return o!=null&&o.set&&(o!=null&&o.get)?o.set.call(r,n)||!0:Reflect.set(i,t,n)}};function nc(){return Reflect.ownKeys(this).reduce((t,n)=>(t[n]=Reflect.get(this,n),t),{})}function Ci(e){let t=r=>typeof r=="object"&&!Array.isArray(r)&&r!==null,n=(r,i="")=>{Object.entries(Object.getOwnPropertyDescriptors(r)).forEach(([o,{value:s,enumerable:a}])=>{if(a===!1||s===void 0||typeof s=="object"&&s!==null&&s.__v_skip)return;let c=i===""?o:`${i}.${o}`;typeof s=="object"&&s!==null&&s._x_interceptor?r[o]=s.initialize(e,c,o):t(s)&&s!==r&&!(s instanceof Element)&&n(s,c)})};return n(e)}function Oi(e,t=()=>{}){let n={initialValue:void 0,_x_interceptor:!0,initialize(r,i,o){return e(this.initialValue,()=>rc(r,i),s=>Zt(r,i,s),i,o)}};return t(n),r=>{if(typeof r=="object"&&r!==null&&r._x_interceptor){let i=n.initialize.bind(n);n.initialize=(o,s,a)=>{let c=r.initialize(o,s,a);return n.initialValue=c,i(o,s,a)}}else n.initialValue=r;return n}}function rc(e,t){return t.split(".").reduce((n,r)=>n[r],e)}function Zt(e,t,n){if(typeof t=="string"&&(t=t.split(".")),t.length===1)e[t[0]]=n;else{if(t.length===0)throw error;return e[t[0]]||(e[t[0]]={}),Zt(e[t[0]],t.slice(1),n)}}var Ii={};function L(e,t){Ii[e]=t}function en(e,t){let n=ic(t);return Object.entries(Ii).forEach(([r,i])=>{Object.defineProperty(e,`$${r}`,{get(){return i(t,n)},enumerable:!1})}),e}function ic(e){let[t,n]=Mi(e),r={interceptor:Oi,...t};return An(e,n),r}function oc(e,t,n,...r){try{return n(...r)}catch(i){Pe(i,e,t)}}function Pe(e,t,n=void 0){e=Object.assign(e??{message:"No error message given."},{el:t,expression:n}),console.warn(`Alpine Expression Error: ${e.message}

${n?'Expression: "'+n+`"

`:""}`,t),setTimeout(()=>{throw e},0)}var Qe=!0;function Ri(e){let t=Qe;Qe=!1;let n=e();return Qe=t,n}function se(e,t,n={}){let r;return D(e,t)(i=>r=i,n),r}function D(...e){return Di(...e)}var Di=Ni;function sc(e){Di=e}function Ni(e,t){let n={};en(n,e);let r=[n,...me(e)],i=typeof t=="function"?ac(r,t):uc(r,t,e);return oc.bind(null,e,t,i)}function ac(e,t){return(n=()=>{},{scope:r={},params:i=[]}={})=>{let o=t.apply(He([r,...e]),i);rt(n,o)}}var Ot={};function cc(e,t){if(Ot[e])return Ot[e];let n=Object.getPrototypeOf(async function(){}).constructor,r=/^[\n\s]*if.*\(.*\)/.test(e.trim())||/^(let|const)\s/.test(e.trim())?`(async()=>{ ${e} })()`:e,o=(()=>{try{let s=new n(["__self","scope"],`with (scope) { __self.result = ${r} }; __self.finished = true; return __self.result;`);return Object.defineProperty(s,"name",{value:`[Alpine] ${e}`}),s}catch(s){return Pe(s,t,e),Promise.resolve()}})();return Ot[e]=o,o}function uc(e,t,n){let r=cc(t,n);return(i=()=>{},{scope:o={},params:s=[]}={})=>{r.result=void 0,r.finished=!1;let a=He([o,...e]);if(typeof r=="function"){let c=r(r,a).catch(u=>Pe(u,n,t));r.finished?(rt(i,r.result,a,s,n),r.result=void 0):c.then(u=>{rt(i,u,a,s,n)}).catch(u=>Pe(u,n,t)).finally(()=>r.result=void 0)}}}function rt(e,t,n,r,i){if(Qe&&typeof t=="function"){let o=t.apply(n,r);o instanceof Promise?o.then(s=>rt(e,s,n,r)).catch(s=>Pe(s,i,t)):e(o)}else typeof t=="object"&&t instanceof Promise?t.then(o=>e(o)):e(t)}var In="x-";function Se(e=""){return In+e}function lc(e){In=e}var it={};function O(e,t){return it[e]=t,{before(n){if(!it[n]){console.warn(String.raw`Cannot find directive \`${n}\`. \`${e}\` will use the default order of execution`);return}const r=ne.indexOf(n);ne.splice(r>=0?r:ne.indexOf("DEFAULT"),0,e)}}}function fc(e){return Object.keys(it).includes(e)}function Rn(e,t,n){if(t=Array.from(t),e._x_virtualDirectives){let o=Object.entries(e._x_virtualDirectives).map(([a,c])=>({name:a,value:c})),s=ki(o);o=o.map(a=>s.find(c=>c.name===a.name)?{name:`x-bind:${a.name}`,value:`"${a.value}"`}:a),t=t.concat(o)}let r={};return t.map(Li((o,s)=>r[o]=s)).filter(ji).map(hc(r,n)).sort(gc).map(o=>pc(e,o))}function ki(e){return Array.from(e).map(Li()).filter(t=>!ji(t))}var tn=!1,Re=new Map,Pi=Symbol();function dc(e){tn=!0;let t=Symbol();Pi=t,Re.set(t,[]);let n=()=>{for(;Re.get(t).length;)Re.get(t).shift()();Re.delete(t)},r=()=>{tn=!1,n()};e(n),r()}function Mi(e){let t=[],n=a=>t.push(a),[r,i]=Ga(e);return t.push(i),[{Alpine:Ue,effect:r,cleanup:n,evaluateLater:D.bind(D,e),evaluate:se.bind(se,e)},()=>t.forEach(a=>a())]}function pc(e,t){let n=()=>{},r=it[t.type]||n,[i,o]=Mi(e);Ai(e,t.original,o);let s=()=>{e._x_ignore||e._x_ignoreSelf||(r.inline&&r.inline(e,t,i),r=r.bind(r,e,t,i),tn?Re.get(Pi).push(r):r())};return s.runCleanups=o,s}var Bi=(e,t)=>({name:n,value:r})=>(n.startsWith(e)&&(n=n.replace(e,t)),{name:n,value:r}),$i=e=>e;function Li(e=()=>{}){return({name:t,value:n})=>{let{name:r,value:i}=Fi.reduce((o,s)=>s(o),{name:t,value:n});return r!==t&&e(r,t),{name:r,value:i}}}var Fi=[];function Dn(e){Fi.push(e)}function ji({name:e}){return Hi().test(e)}var Hi=()=>new RegExp(`^${In}([^:^.]+)\\b`);function hc(e,t){return({name:n,value:r})=>{let i=n.match(Hi()),o=n.match(/:([a-zA-Z0-9\-_:]+)/),s=n.match(/\.[^.\]]+(?=[^\]]*$)/g)||[],a=t||e[n]||n;return{type:i?i[1]:null,value:o?o[1]:null,modifiers:s.map(c=>c.replace(".","")),expression:r,original:a}}}var nn="DEFAULT",ne=["ignore","ref","data","id","anchor","bind","init","for","model","modelable","transition","show","if",nn,"teleport"];function gc(e,t){let n=ne.indexOf(e.type)===-1?nn:e.type,r=ne.indexOf(t.type)===-1?nn:t.type;return ne.indexOf(n)-ne.indexOf(r)}function De(e,t,n={}){e.dispatchEvent(new CustomEvent(t,{detail:n,bubbles:!0,composed:!0,cancelable:!0}))}function le(e,t){if(typeof ShadowRoot=="function"&&e instanceof ShadowRoot){Array.from(e.children).forEach(i=>le(i,t));return}let n=!1;if(t(e,()=>n=!0),n)return;let r=e.firstElementChild;for(;r;)le(r,t),r=r.nextElementSibling}function M(e,...t){console.warn(`Alpine Warning: ${e}`,...t)}var hr=!1;function mc(){hr&&M("Alpine has already been initialized on this page. Calling Alpine.start() more than once can cause problems."),hr=!0,document.body||M("Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?"),De(document,"alpine:init"),De(document,"alpine:initializing"),Tn(),Xa(t=>K(t,le)),An(t=>ve(t)),Si((t,n)=>{Rn(t,n).forEach(r=>r())});let e=t=>!ht(t.parentElement,!0);Array.from(document.querySelectorAll(Ki().join(","))).filter(e).forEach(t=>{K(t)}),De(document,"alpine:initialized"),setTimeout(()=>{wc()})}var Nn=[],Ui=[];function qi(){return Nn.map(e=>e())}function Ki(){return Nn.concat(Ui).map(e=>e())}function zi(e){Nn.push(e)}function Vi(e){Ui.push(e)}function ht(e,t=!1){return Ae(e,n=>{if((t?Ki():qi()).some(i=>n.matches(i)))return!0})}function Ae(e,t){if(e){if(t(e))return e;if(e._x_teleportBack&&(e=e._x_teleportBack),!!e.parentElement)return Ae(e.parentElement,t)}}function bc(e){return qi().some(t=>e.matches(t))}var Wi=[];function _c(e){Wi.push(e)}var yc=1;function K(e,t=le,n=()=>{}){Ae(e,r=>r._x_ignore)||dc(()=>{t(e,(r,i)=>{r._x_marker||(n(r,i),Wi.forEach(o=>o(r,i)),Rn(r,r.attributes).forEach(o=>o()),r._x_ignore||(r._x_marker=yc++),r._x_ignore&&i())})})}function ve(e,t=le){t(e,n=>{Ya(n),vi(n),delete n._x_marker})}function wc(){[["ui","dialog",["[x-dialog], [x-popover]"]],["anchor","anchor",["[x-anchor]"]],["sort","sort",["[x-sort]"]]].forEach(([t,n,r])=>{fc(n)||r.some(i=>{if(document.querySelector(i))return M(`found "${i}", but missing ${t} plugin`),!0})})}var rn=[],kn=!1;function Pn(e=()=>{}){return queueMicrotask(()=>{kn||setTimeout(()=>{on()})}),new Promise(t=>{rn.push(()=>{e(),t()})})}function on(){for(kn=!1;rn.length;)rn.shift()()}function Ec(){kn=!0}function Mn(e,t){return Array.isArray(t)?gr(e,t.join(" ")):typeof t=="object"&&t!==null?Sc(e,t):typeof t=="function"?Mn(e,t()):gr(e,t)}function gr(e,t){let n=i=>i.split(" ").filter(o=>!e.classList.contains(o)).filter(Boolean),r=i=>(e.classList.add(...i),()=>{e.classList.remove(...i)});return t=t===!0?t="":t||"",r(n(t))}function Sc(e,t){let n=a=>a.split(" ").filter(Boolean),r=Object.entries(t).flatMap(([a,c])=>c?n(a):!1).filter(Boolean),i=Object.entries(t).flatMap(([a,c])=>c?!1:n(a)).filter(Boolean),o=[],s=[];return i.forEach(a=>{e.classList.contains(a)&&(e.classList.remove(a),s.push(a))}),r.forEach(a=>{e.classList.contains(a)||(e.classList.add(a),o.push(a))}),()=>{s.forEach(a=>e.classList.add(a)),o.forEach(a=>e.classList.remove(a))}}function gt(e,t){return typeof t=="object"&&t!==null?Ac(e,t):vc(e,t)}function Ac(e,t){let n={};return Object.entries(t).forEach(([r,i])=>{n[r]=e.style[r],r.startsWith("--")||(r=xc(r)),e.style.setProperty(r,i)}),setTimeout(()=>{e.style.length===0&&e.removeAttribute("style")}),()=>{gt(e,n)}}function vc(e,t){let n=e.getAttribute("style",t);return e.setAttribute("style",t),()=>{e.setAttribute("style",n||"")}}function xc(e){return e.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase()}function sn(e,t=()=>{}){let n=!1;return function(){n?t.apply(this,arguments):(n=!0,e.apply(this,arguments))}}O("transition",(e,{value:t,modifiers:n,expression:r},{evaluate:i})=>{typeof r=="function"&&(r=i(r)),r!==!1&&(!r||typeof r=="boolean"?Cc(e,n,t):Tc(e,r,t))});function Tc(e,t,n){Ji(e,Mn,""),{enter:i=>{e._x_transition.enter.during=i},"enter-start":i=>{e._x_transition.enter.start=i},"enter-end":i=>{e._x_transition.enter.end=i},leave:i=>{e._x_transition.leave.during=i},"leave-start":i=>{e._x_transition.leave.start=i},"leave-end":i=>{e._x_transition.leave.end=i}}[n](t)}function Cc(e,t,n){Ji(e,gt);let r=!t.includes("in")&&!t.includes("out")&&!n,i=r||t.includes("in")||["enter"].includes(n),o=r||t.includes("out")||["leave"].includes(n);t.includes("in")&&!r&&(t=t.filter((_,w)=>w<t.indexOf("out"))),t.includes("out")&&!r&&(t=t.filter((_,w)=>w>t.indexOf("out")));let s=!t.includes("opacity")&&!t.includes("scale"),a=s||t.includes("opacity"),c=s||t.includes("scale"),u=a?0:1,l=c?Oe(t,"scale",95)/100:1,p=Oe(t,"delay",0)/1e3,h=Oe(t,"origin","center"),b="opacity, transform",g=Oe(t,"duration",150)/1e3,m=Oe(t,"duration",75)/1e3,d="cubic-bezier(0.4, 0.0, 0.2, 1)";i&&(e._x_transition.enter.during={transformOrigin:h,transitionDelay:`${p}s`,transitionProperty:b,transitionDuration:`${g}s`,transitionTimingFunction:d},e._x_transition.enter.start={opacity:u,transform:`scale(${l})`},e._x_transition.enter.end={opacity:1,transform:"scale(1)"}),o&&(e._x_transition.leave.during={transformOrigin:h,transitionDelay:`${p}s`,transitionProperty:b,transitionDuration:`${m}s`,transitionTimingFunction:d},e._x_transition.leave.start={opacity:1,transform:"scale(1)"},e._x_transition.leave.end={opacity:u,transform:`scale(${l})`})}function Ji(e,t,n={}){e._x_transition||(e._x_transition={enter:{during:n,start:n,end:n},leave:{during:n,start:n,end:n},in(r=()=>{},i=()=>{}){an(e,t,{during:this.enter.during,start:this.enter.start,end:this.enter.end},r,i)},out(r=()=>{},i=()=>{}){an(e,t,{during:this.leave.during,start:this.leave.start,end:this.leave.end},r,i)}})}window.Element.prototype._x_toggleAndCascadeWithTransitions=function(e,t,n,r){const i=document.visibilityState==="visible"?requestAnimationFrame:setTimeout;let o=()=>i(n);if(t){e._x_transition&&(e._x_transition.enter||e._x_transition.leave)?e._x_transition.enter&&(Object.entries(e._x_transition.enter.during).length||Object.entries(e._x_transition.enter.start).length||Object.entries(e._x_transition.enter.end).length)?e._x_transition.in(n):o():e._x_transition?e._x_transition.in(n):o();return}e._x_hidePromise=e._x_transition?new Promise((s,a)=>{e._x_transition.out(()=>{},()=>s(r)),e._x_transitioning&&e._x_transitioning.beforeCancel(()=>a({isFromCancelledTransition:!0}))}):Promise.resolve(r),queueMicrotask(()=>{let s=Gi(e);s?(s._x_hideChildren||(s._x_hideChildren=[]),s._x_hideChildren.push(e)):i(()=>{let a=c=>{let u=Promise.all([c._x_hidePromise,...(c._x_hideChildren||[]).map(a)]).then(([l])=>l==null?void 0:l());return delete c._x_hidePromise,delete c._x_hideChildren,u};a(e).catch(c=>{if(!c.isFromCancelledTransition)throw c})})})};function Gi(e){let t=e.parentNode;if(t)return t._x_hidePromise?t:Gi(t)}function an(e,t,{during:n,start:r,end:i}={},o=()=>{},s=()=>{}){if(e._x_transitioning&&e._x_transitioning.cancel(),Object.keys(n).length===0&&Object.keys(r).length===0&&Object.keys(i).length===0){o(),s();return}let a,c,u;Oc(e,{start(){a=t(e,r)},during(){c=t(e,n)},before:o,end(){a(),u=t(e,i)},after:s,cleanup(){c(),u()}})}function Oc(e,t){let n,r,i,o=sn(()=>{v(()=>{n=!0,r||t.before(),i||(t.end(),on()),t.after(),e.isConnected&&t.cleanup(),delete e._x_transitioning})});e._x_transitioning={beforeCancels:[],beforeCancel(s){this.beforeCancels.push(s)},cancel:sn(function(){for(;this.beforeCancels.length;)this.beforeCancels.shift()();o()}),finish:o},v(()=>{t.start(),t.during()}),Ec(),requestAnimationFrame(()=>{if(n)return;let s=Number(getComputedStyle(e).transitionDuration.replace(/,.*/,"").replace("s",""))*1e3,a=Number(getComputedStyle(e).transitionDelay.replace(/,.*/,"").replace("s",""))*1e3;s===0&&(s=Number(getComputedStyle(e).animationDuration.replace("s",""))*1e3),v(()=>{t.before()}),r=!0,requestAnimationFrame(()=>{n||(v(()=>{t.end()}),on(),setTimeout(e._x_transitioning.finish,s+a),i=!0)})})}function Oe(e,t,n){if(e.indexOf(t)===-1)return n;const r=e[e.indexOf(t)+1];if(!r||t==="scale"&&isNaN(r))return n;if(t==="duration"||t==="delay"){let i=r.match(/([0-9]+)ms/);if(i)return i[1]}return t==="origin"&&["top","right","left","center","bottom"].includes(e[e.indexOf(t)+2])?[r,e[e.indexOf(t)+2]].join(" "):r}var G=!1;function Q(e,t=()=>{}){return(...n)=>G?t(...n):e(...n)}function Ic(e){return(...t)=>G&&e(...t)}var Xi=[];function mt(e){Xi.push(e)}function Rc(e,t){Xi.forEach(n=>n(e,t)),G=!0,Yi(()=>{K(t,(n,r)=>{r(n,()=>{})})}),G=!1}var cn=!1;function Dc(e,t){t._x_dataStack||(t._x_dataStack=e._x_dataStack),G=!0,cn=!0,Yi(()=>{Nc(t)}),G=!1,cn=!1}function Nc(e){let t=!1;K(e,(r,i)=>{le(r,(o,s)=>{if(t&&bc(o))return s();t=!0,i(o,s)})})}function Yi(e){let t=he;pr((n,r)=>{let i=t(n);return Ee(i),()=>{}}),e(),pr(t)}function Qi(e,t,n,r=[]){switch(e._x_bindings||(e._x_bindings=we({})),e._x_bindings[t]=n,t=r.includes("camel")?jc(t):t,t){case"value":kc(e,n);break;case"style":Mc(e,n);break;case"class":Pc(e,n);break;case"selected":case"checked":Bc(e,t,n);break;default:Zi(e,t,n);break}}function kc(e,t){if(no(e))e.attributes.value===void 0&&(e.value=t),window.fromModel&&(typeof t=="boolean"?e.checked=Ze(e.value)===t:e.checked=mr(e.value,t));else if(Bn(e))Number.isInteger(t)?e.value=t:!Array.isArray(t)&&typeof t!="boolean"&&![null,void 0].includes(t)?e.value=String(t):Array.isArray(t)?e.checked=t.some(n=>mr(n,e.value)):e.checked=!!t;else if(e.tagName==="SELECT")Fc(e,t);else{if(e.value===t)return;e.value=t===void 0?"":t}}function Pc(e,t){e._x_undoAddedClasses&&e._x_undoAddedClasses(),e._x_undoAddedClasses=Mn(e,t)}function Mc(e,t){e._x_undoAddedStyles&&e._x_undoAddedStyles(),e._x_undoAddedStyles=gt(e,t)}function Bc(e,t,n){Zi(e,t,n),Lc(e,t,n)}function Zi(e,t,n){[null,void 0,!1].includes(n)&&Uc(t)?e.removeAttribute(t):(eo(t)&&(n=t),$c(e,t,n))}function $c(e,t,n){e.getAttribute(t)!=n&&e.setAttribute(t,n)}function Lc(e,t,n){e[t]!==n&&(e[t]=n)}function Fc(e,t){const n=[].concat(t).map(r=>r+"");Array.from(e.options).forEach(r=>{r.selected=n.includes(r.value)})}function jc(e){return e.toLowerCase().replace(/-(\w)/g,(t,n)=>n.toUpperCase())}function mr(e,t){return e==t}function Ze(e){return[1,"1","true","on","yes",!0].includes(e)?!0:[0,"0","false","off","no",!1].includes(e)?!1:e?!!e:null}var Hc=new Set(["allowfullscreen","async","autofocus","autoplay","checked","controls","default","defer","disabled","formnovalidate","inert","ismap","itemscope","loop","multiple","muted","nomodule","novalidate","open","playsinline","readonly","required","reversed","selected","shadowrootclonable","shadowrootdelegatesfocus","shadowrootserializable"]);function eo(e){return Hc.has(e)}function Uc(e){return!["aria-pressed","aria-checked","aria-expanded","aria-selected"].includes(e)}function qc(e,t,n){return e._x_bindings&&e._x_bindings[t]!==void 0?e._x_bindings[t]:to(e,t,n)}function Kc(e,t,n,r=!0){if(e._x_bindings&&e._x_bindings[t]!==void 0)return e._x_bindings[t];if(e._x_inlineBindings&&e._x_inlineBindings[t]!==void 0){let i=e._x_inlineBindings[t];return i.extract=r,Ri(()=>se(e,i.expression))}return to(e,t,n)}function to(e,t,n){let r=e.getAttribute(t);return r===null?typeof n=="function"?n():n:r===""?!0:eo(t)?!![t,"true"].includes(r):r}function Bn(e){return e.type==="checkbox"||e.localName==="ui-checkbox"||e.localName==="ui-switch"}function no(e){return e.type==="radio"||e.localName==="ui-radio"}function ro(e,t){var n;return function(){var r=this,i=arguments,o=function(){n=null,e.apply(r,i)};clearTimeout(n),n=setTimeout(o,t)}}function io(e,t){let n;return function(){let r=this,i=arguments;n||(e.apply(r,i),n=!0,setTimeout(()=>n=!1,t))}}function oo({get:e,set:t},{get:n,set:r}){let i=!0,o,s=he(()=>{let a=e(),c=n();if(i)r(It(a)),i=!1;else{let u=JSON.stringify(a),l=JSON.stringify(c);u!==o?r(It(a)):u!==l&&t(It(c))}o=JSON.stringify(e()),JSON.stringify(n())});return()=>{Ee(s)}}function It(e){return typeof e=="object"?JSON.parse(JSON.stringify(e)):e}function zc(e){(Array.isArray(e)?e:[e]).forEach(n=>n(Ue))}var Z={},br=!1;function Vc(e,t){if(br||(Z=we(Z),br=!0),t===void 0)return Z[e];Z[e]=t,Ci(Z[e]),typeof t=="object"&&t!==null&&t.hasOwnProperty("init")&&typeof t.init=="function"&&Z[e].init()}function Wc(){return Z}var so={};function Jc(e,t){let n=typeof t!="function"?()=>t:t;return e instanceof Element?ao(e,n()):(so[e]=n,()=>{})}function Gc(e){return Object.entries(so).forEach(([t,n])=>{Object.defineProperty(e,t,{get(){return(...r)=>n(...r)}})}),e}function ao(e,t,n){let r=[];for(;r.length;)r.pop()();let i=Object.entries(t).map(([s,a])=>({name:s,value:a})),o=ki(i);return i=i.map(s=>o.find(a=>a.name===s.name)?{name:`x-bind:${s.name}`,value:`"${s.value}"`}:s),Rn(e,i,n).map(s=>{r.push(s.runCleanups),s()}),()=>{for(;r.length;)r.pop()()}}var co={};function Xc(e,t){co[e]=t}function Yc(e,t){return Object.entries(co).forEach(([n,r])=>{Object.defineProperty(e,n,{get(){return(...i)=>r.bind(t)(...i)},enumerable:!1})}),e}var Qc={get reactive(){return we},get release(){return Ee},get effect(){return he},get raw(){return bi},version:"3.14.9",flushAndStopDeferringMutations:ec,dontAutoEvaluateFunctions:Ri,disableEffectScheduling:Wa,startObservingMutations:Tn,stopObservingMutations:xi,setReactivityEngine:Ja,onAttributeRemoved:Ai,onAttributesAdded:Si,closestDataStack:me,skipDuringClone:Q,onlyDuringClone:Ic,addRootSelector:zi,addInitSelector:Vi,interceptClone:mt,addScopeToNode:je,deferMutations:Za,mapAttributes:Dn,evaluateLater:D,interceptInit:_c,setEvaluator:sc,mergeProxies:He,extractProp:Kc,findClosest:Ae,onElRemoved:An,closestRoot:ht,destroyTree:ve,interceptor:Oi,transition:an,setStyles:gt,mutateDom:v,directive:O,entangle:oo,throttle:io,debounce:ro,evaluate:se,initTree:K,nextTick:Pn,prefixed:Se,prefix:lc,plugin:zc,magic:L,store:Vc,start:mc,clone:Dc,cloneNode:Rc,bound:qc,$data:Ti,watch:_i,walk:le,data:Xc,bind:Jc},Ue=Qc;function Zc(e,t){const n=Object.create(null),r=e.split(",");for(let i=0;i<r.length;i++)n[r[i]]=!0;return i=>!!n[i]}var eu=Object.freeze({}),tu=Object.prototype.hasOwnProperty,bt=(e,t)=>tu.call(e,t),ae=Array.isArray,Ne=e=>uo(e)==="[object Map]",nu=e=>typeof e=="string",$n=e=>typeof e=="symbol",_t=e=>e!==null&&typeof e=="object",ru=Object.prototype.toString,uo=e=>ru.call(e),lo=e=>uo(e).slice(8,-1),Ln=e=>nu(e)&&e!=="NaN"&&e[0]!=="-"&&""+parseInt(e,10)===e,iu=e=>{const t=Object.create(null);return n=>t[n]||(t[n]=e(n))},ou=iu(e=>e.charAt(0).toUpperCase()+e.slice(1)),fo=(e,t)=>e!==t&&(e===e||t===t),un=new WeakMap,Ie=[],H,ce=Symbol("iterate"),ln=Symbol("Map key iterate");function su(e){return e&&e._isEffect===!0}function au(e,t=eu){su(e)&&(e=e.raw);const n=lu(e,t);return t.lazy||n(),n}function cu(e){e.active&&(po(e),e.options.onStop&&e.options.onStop(),e.active=!1)}var uu=0;function lu(e,t){const n=function(){if(!n.active)return e();if(!Ie.includes(n)){po(n);try{return du(),Ie.push(n),H=n,e()}finally{Ie.pop(),ho(),H=Ie[Ie.length-1]}}};return n.id=uu++,n.allowRecurse=!!t.allowRecurse,n._isEffect=!0,n.active=!0,n.raw=e,n.deps=[],n.options=t,n}function po(e){const{deps:t}=e;if(t.length){for(let n=0;n<t.length;n++)t[n].delete(e);t.length=0}}var be=!0,Fn=[];function fu(){Fn.push(be),be=!1}function du(){Fn.push(be),be=!0}function ho(){const e=Fn.pop();be=e===void 0?!0:e}function B(e,t,n){if(!be||H===void 0)return;let r=un.get(e);r||un.set(e,r=new Map);let i=r.get(n);i||r.set(n,i=new Set),i.has(H)||(i.add(H),H.deps.push(i),H.options.onTrack&&H.options.onTrack({effect:H,target:e,type:t,key:n}))}function X(e,t,n,r,i,o){const s=un.get(e);if(!s)return;const a=new Set,c=l=>{l&&l.forEach(p=>{(p!==H||p.allowRecurse)&&a.add(p)})};if(t==="clear")s.forEach(c);else if(n==="length"&&ae(e))s.forEach((l,p)=>{(p==="length"||p>=r)&&c(l)});else switch(n!==void 0&&c(s.get(n)),t){case"add":ae(e)?Ln(n)&&c(s.get("length")):(c(s.get(ce)),Ne(e)&&c(s.get(ln)));break;case"delete":ae(e)||(c(s.get(ce)),Ne(e)&&c(s.get(ln)));break;case"set":Ne(e)&&c(s.get(ce));break}const u=l=>{l.options.onTrigger&&l.options.onTrigger({effect:l,target:e,key:n,type:t,newValue:r,oldValue:i,oldTarget:o}),l.options.scheduler?l.options.scheduler(l):l()};a.forEach(u)}var pu=Zc("__proto__,__v_isRef,__isVue"),go=new Set(Object.getOwnPropertyNames(Symbol).map(e=>Symbol[e]).filter($n)),hu=mo(),gu=mo(!0),_r=mu();function mu(){const e={};return["includes","indexOf","lastIndexOf"].forEach(t=>{e[t]=function(...n){const r=A(this);for(let o=0,s=this.length;o<s;o++)B(r,"get",o+"");const i=r[t](...n);return i===-1||i===!1?r[t](...n.map(A)):i}}),["push","pop","shift","unshift","splice"].forEach(t=>{e[t]=function(...n){fu();const r=A(this)[t].apply(this,n);return ho(),r}}),e}function mo(e=!1,t=!1){return function(r,i,o){if(i==="__v_isReactive")return!e;if(i==="__v_isReadonly")return e;if(i==="__v_raw"&&o===(e?t?Ru:wo:t?Iu:yo).get(r))return r;const s=ae(r);if(!e&&s&&bt(_r,i))return Reflect.get(_r,i,o);const a=Reflect.get(r,i,o);return($n(i)?go.has(i):pu(i))||(e||B(r,"get",i),t)?a:fn(a)?!s||!Ln(i)?a.value:a:_t(a)?e?Eo(a):qn(a):a}}var bu=_u();function _u(e=!1){return function(n,r,i,o){let s=n[r];if(!e&&(i=A(i),s=A(s),!ae(n)&&fn(s)&&!fn(i)))return s.value=i,!0;const a=ae(n)&&Ln(r)?Number(r)<n.length:bt(n,r),c=Reflect.set(n,r,i,o);return n===A(o)&&(a?fo(i,s)&&X(n,"set",r,i,s):X(n,"add",r,i)),c}}function yu(e,t){const n=bt(e,t),r=e[t],i=Reflect.deleteProperty(e,t);return i&&n&&X(e,"delete",t,void 0,r),i}function wu(e,t){const n=Reflect.has(e,t);return(!$n(t)||!go.has(t))&&B(e,"has",t),n}function Eu(e){return B(e,"iterate",ae(e)?"length":ce),Reflect.ownKeys(e)}var Su={get:hu,set:bu,deleteProperty:yu,has:wu,ownKeys:Eu},Au={get:gu,set(e,t){return console.warn(`Set operation on key "${String(t)}" failed: target is readonly.`,e),!0},deleteProperty(e,t){return console.warn(`Delete operation on key "${String(t)}" failed: target is readonly.`,e),!0}},jn=e=>_t(e)?qn(e):e,Hn=e=>_t(e)?Eo(e):e,Un=e=>e,yt=e=>Reflect.getPrototypeOf(e);function Ke(e,t,n=!1,r=!1){e=e.__v_raw;const i=A(e),o=A(t);t!==o&&!n&&B(i,"get",t),!n&&B(i,"get",o);const{has:s}=yt(i),a=r?Un:n?Hn:jn;if(s.call(i,t))return a(e.get(t));if(s.call(i,o))return a(e.get(o));e!==i&&e.get(t)}function ze(e,t=!1){const n=this.__v_raw,r=A(n),i=A(e);return e!==i&&!t&&B(r,"has",e),!t&&B(r,"has",i),e===i?n.has(e):n.has(e)||n.has(i)}function Ve(e,t=!1){return e=e.__v_raw,!t&&B(A(e),"iterate",ce),Reflect.get(e,"size",e)}function yr(e){e=A(e);const t=A(this);return yt(t).has.call(t,e)||(t.add(e),X(t,"add",e,e)),this}function wr(e,t){t=A(t);const n=A(this),{has:r,get:i}=yt(n);let o=r.call(n,e);o?_o(n,r,e):(e=A(e),o=r.call(n,e));const s=i.call(n,e);return n.set(e,t),o?fo(t,s)&&X(n,"set",e,t,s):X(n,"add",e,t),this}function Er(e){const t=A(this),{has:n,get:r}=yt(t);let i=n.call(t,e);i?_o(t,n,e):(e=A(e),i=n.call(t,e));const o=r?r.call(t,e):void 0,s=t.delete(e);return i&&X(t,"delete",e,void 0,o),s}function Sr(){const e=A(this),t=e.size!==0,n=Ne(e)?new Map(e):new Set(e),r=e.clear();return t&&X(e,"clear",void 0,void 0,n),r}function We(e,t){return function(r,i){const o=this,s=o.__v_raw,a=A(s),c=t?Un:e?Hn:jn;return!e&&B(a,"iterate",ce),s.forEach((u,l)=>r.call(i,c(u),c(l),o))}}function Je(e,t,n){return function(...r){const i=this.__v_raw,o=A(i),s=Ne(o),a=e==="entries"||e===Symbol.iterator&&s,c=e==="keys"&&s,u=i[e](...r),l=n?Un:t?Hn:jn;return!t&&B(o,"iterate",c?ln:ce),{next(){const{value:p,done:h}=u.next();return h?{value:p,done:h}:{value:a?[l(p[0]),l(p[1])]:l(p),done:h}},[Symbol.iterator](){return this}}}}function V(e){return function(...t){{const n=t[0]?`on key "${t[0]}" `:"";console.warn(`${ou(e)} operation ${n}failed: target is readonly.`,A(this))}return e==="delete"?!1:this}}function vu(){const e={get(o){return Ke(this,o)},get size(){return Ve(this)},has:ze,add:yr,set:wr,delete:Er,clear:Sr,forEach:We(!1,!1)},t={get(o){return Ke(this,o,!1,!0)},get size(){return Ve(this)},has:ze,add:yr,set:wr,delete:Er,clear:Sr,forEach:We(!1,!0)},n={get(o){return Ke(this,o,!0)},get size(){return Ve(this,!0)},has(o){return ze.call(this,o,!0)},add:V("add"),set:V("set"),delete:V("delete"),clear:V("clear"),forEach:We(!0,!1)},r={get(o){return Ke(this,o,!0,!0)},get size(){return Ve(this,!0)},has(o){return ze.call(this,o,!0)},add:V("add"),set:V("set"),delete:V("delete"),clear:V("clear"),forEach:We(!0,!0)};return["keys","values","entries",Symbol.iterator].forEach(o=>{e[o]=Je(o,!1,!1),n[o]=Je(o,!0,!1),t[o]=Je(o,!1,!0),r[o]=Je(o,!0,!0)}),[e,n,t,r]}var[xu,Tu,Ep,Sp]=vu();function bo(e,t){const n=e?Tu:xu;return(r,i,o)=>i==="__v_isReactive"?!e:i==="__v_isReadonly"?e:i==="__v_raw"?r:Reflect.get(bt(n,i)&&i in r?n:r,i,o)}var Cu={get:bo(!1)},Ou={get:bo(!0)};function _o(e,t,n){const r=A(n);if(r!==n&&t.call(e,r)){const i=lo(e);console.warn(`Reactive ${i} contains both the raw and reactive versions of the same object${i==="Map"?" as keys":""}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`)}}var yo=new WeakMap,Iu=new WeakMap,wo=new WeakMap,Ru=new WeakMap;function Du(e){switch(e){case"Object":case"Array":return 1;case"Map":case"Set":case"WeakMap":case"WeakSet":return 2;default:return 0}}function Nu(e){return e.__v_skip||!Object.isExtensible(e)?0:Du(lo(e))}function qn(e){return e&&e.__v_isReadonly?e:So(e,!1,Su,Cu,yo)}function Eo(e){return So(e,!0,Au,Ou,wo)}function So(e,t,n,r,i){if(!_t(e))return console.warn(`value cannot be made reactive: ${String(e)}`),e;if(e.__v_raw&&!(t&&e.__v_isReactive))return e;const o=i.get(e);if(o)return o;const s=Nu(e);if(s===0)return e;const a=new Proxy(e,s===2?r:n);return i.set(e,a),a}function A(e){return e&&A(e.__v_raw)||e}function fn(e){return!!(e&&e.__v_isRef===!0)}L("nextTick",()=>Pn);L("dispatch",e=>De.bind(De,e));L("watch",(e,{evaluateLater:t,cleanup:n})=>(r,i)=>{let o=t(r),a=_i(()=>{let c;return o(u=>c=u),c},i);n(a)});L("store",Wc);L("data",e=>Ti(e));L("root",e=>ht(e));L("refs",e=>(e._x_refs_proxy||(e._x_refs_proxy=He(ku(e))),e._x_refs_proxy));function ku(e){let t=[];return Ae(e,n=>{n._x_refs&&t.push(n._x_refs)}),t}var Rt={};function Ao(e){return Rt[e]||(Rt[e]=0),++Rt[e]}function Pu(e,t){return Ae(e,n=>{if(n._x_ids&&n._x_ids[t])return!0})}function Mu(e,t){e._x_ids||(e._x_ids={}),e._x_ids[t]||(e._x_ids[t]=Ao(t))}L("id",(e,{cleanup:t})=>(n,r=null)=>{let i=`${n}${r?`-${r}`:""}`;return Bu(e,i,t,()=>{let o=Pu(e,n),s=o?o._x_ids[n]:Ao(n);return r?`${n}-${s}-${r}`:`${n}-${s}`})});mt((e,t)=>{e._x_id&&(t._x_id=e._x_id)});function Bu(e,t,n,r){if(e._x_id||(e._x_id={}),e._x_id[t])return e._x_id[t];let i=r();return e._x_id[t]=i,n(()=>{delete e._x_id[t]}),i}L("el",e=>e);vo("Focus","focus","focus");vo("Persist","persist","persist");function vo(e,t,n){L(t,r=>M(`You can't use [$${t}] without first installing the "${e}" plugin here: https://alpinejs.dev/plugins/${n}`,r))}O("modelable",(e,{expression:t},{effect:n,evaluateLater:r,cleanup:i})=>{let o=r(t),s=()=>{let l;return o(p=>l=p),l},a=r(`${t} = __placeholder`),c=l=>a(()=>{},{scope:{__placeholder:l}}),u=s();c(u),queueMicrotask(()=>{if(!e._x_model)return;e._x_removeModelListeners.default();let l=e._x_model.get,p=e._x_model.set,h=oo({get(){return l()},set(b){p(b)}},{get(){return s()},set(b){c(b)}});i(h)})});O("teleport",(e,{modifiers:t,expression:n},{cleanup:r})=>{e.tagName.toLowerCase()!=="template"&&M("x-teleport can only be used on a <template> tag",e);let i=Ar(n),o=e.content.cloneNode(!0).firstElementChild;e._x_teleport=o,o._x_teleportBack=e,e.setAttribute("data-teleport-template",!0),o.setAttribute("data-teleport-target",!0),e._x_forwardEvents&&e._x_forwardEvents.forEach(a=>{o.addEventListener(a,c=>{c.stopPropagation(),e.dispatchEvent(new c.constructor(c.type,c))})}),je(o,{},e);let s=(a,c,u)=>{u.includes("prepend")?c.parentNode.insertBefore(a,c):u.includes("append")?c.parentNode.insertBefore(a,c.nextSibling):c.appendChild(a)};v(()=>{s(o,i,t),Q(()=>{K(o)})()}),e._x_teleportPutBack=()=>{let a=Ar(n);v(()=>{s(e._x_teleport,a,t)})},r(()=>v(()=>{o.remove(),ve(o)}))});var $u=document.createElement("div");function Ar(e){let t=Q(()=>document.querySelector(e),()=>$u)();return t||M(`Cannot find x-teleport element for selector: "${e}"`),t}var xo=()=>{};xo.inline=(e,{modifiers:t},{cleanup:n})=>{t.includes("self")?e._x_ignoreSelf=!0:e._x_ignore=!0,n(()=>{t.includes("self")?delete e._x_ignoreSelf:delete e._x_ignore})};O("ignore",xo);O("effect",Q((e,{expression:t},{effect:n})=>{n(D(e,t))}));function dn(e,t,n,r){let i=e,o=c=>r(c),s={},a=(c,u)=>l=>u(c,l);if(n.includes("dot")&&(t=Lu(t)),n.includes("camel")&&(t=Fu(t)),n.includes("passive")&&(s.passive=!0),n.includes("capture")&&(s.capture=!0),n.includes("window")&&(i=window),n.includes("document")&&(i=document),n.includes("debounce")){let c=n[n.indexOf("debounce")+1]||"invalid-wait",u=ot(c.split("ms")[0])?Number(c.split("ms")[0]):250;o=ro(o,u)}if(n.includes("throttle")){let c=n[n.indexOf("throttle")+1]||"invalid-wait",u=ot(c.split("ms")[0])?Number(c.split("ms")[0]):250;o=io(o,u)}return n.includes("prevent")&&(o=a(o,(c,u)=>{u.preventDefault(),c(u)})),n.includes("stop")&&(o=a(o,(c,u)=>{u.stopPropagation(),c(u)})),n.includes("once")&&(o=a(o,(c,u)=>{c(u),i.removeEventListener(t,o,s)})),(n.includes("away")||n.includes("outside"))&&(i=document,o=a(o,(c,u)=>{e.contains(u.target)||u.target.isConnected!==!1&&(e.offsetWidth<1&&e.offsetHeight<1||e._x_isShown!==!1&&c(u))})),n.includes("self")&&(o=a(o,(c,u)=>{u.target===e&&c(u)})),(Hu(t)||To(t))&&(o=a(o,(c,u)=>{Uu(u,n)||c(u)})),i.addEventListener(t,o,s),()=>{i.removeEventListener(t,o,s)}}function Lu(e){return e.replace(/-/g,".")}function Fu(e){return e.toLowerCase().replace(/-(\w)/g,(t,n)=>n.toUpperCase())}function ot(e){return!Array.isArray(e)&&!isNaN(e)}function ju(e){return[" ","_"].includes(e)?e:e.replace(/([a-z])([A-Z])/g,"$1-$2").replace(/[_\s]/,"-").toLowerCase()}function Hu(e){return["keydown","keyup"].includes(e)}function To(e){return["contextmenu","click","mouse"].some(t=>e.includes(t))}function Uu(e,t){let n=t.filter(o=>!["window","document","prevent","stop","once","capture","self","away","outside","passive"].includes(o));if(n.includes("debounce")){let o=n.indexOf("debounce");n.splice(o,ot((n[o+1]||"invalid-wait").split("ms")[0])?2:1)}if(n.includes("throttle")){let o=n.indexOf("throttle");n.splice(o,ot((n[o+1]||"invalid-wait").split("ms")[0])?2:1)}if(n.length===0||n.length===1&&vr(e.key).includes(n[0]))return!1;const i=["ctrl","shift","alt","meta","cmd","super"].filter(o=>n.includes(o));return n=n.filter(o=>!i.includes(o)),!(i.length>0&&i.filter(s=>((s==="cmd"||s==="super")&&(s="meta"),e[`${s}Key`])).length===i.length&&(To(e.type)||vr(e.key).includes(n[0])))}function vr(e){if(!e)return[];e=ju(e);let t={ctrl:"control",slash:"/",space:" ",spacebar:" ",cmd:"meta",esc:"escape",up:"arrow-up",down:"arrow-down",left:"arrow-left",right:"arrow-right",period:".",comma:",",equal:"=",minus:"-",underscore:"_"};return t[e]=e,Object.keys(t).map(n=>{if(t[n]===e)return n}).filter(n=>n)}O("model",(e,{modifiers:t,expression:n},{effect:r,cleanup:i})=>{let o=e;t.includes("parent")&&(o=e.parentNode);let s=D(o,n),a;typeof n=="string"?a=D(o,`${n} = __placeholder`):typeof n=="function"&&typeof n()=="string"?a=D(o,`${n()} = __placeholder`):a=()=>{};let c=()=>{let h;return s(b=>h=b),xr(h)?h.get():h},u=h=>{let b;s(g=>b=g),xr(b)?b.set(h):a(()=>{},{scope:{__placeholder:h}})};typeof n=="string"&&e.type==="radio"&&v(()=>{e.hasAttribute("name")||e.setAttribute("name",n)});var l=e.tagName.toLowerCase()==="select"||["checkbox","radio"].includes(e.type)||t.includes("lazy")?"change":"input";let p=G?()=>{}:dn(e,l,t,h=>{u(Dt(e,t,h,c()))});if(t.includes("fill")&&([void 0,null,""].includes(c())||Bn(e)&&Array.isArray(c())||e.tagName.toLowerCase()==="select"&&e.multiple)&&u(Dt(e,t,{target:e},c())),e._x_removeModelListeners||(e._x_removeModelListeners={}),e._x_removeModelListeners.default=p,i(()=>e._x_removeModelListeners.default()),e.form){let h=dn(e.form,"reset",[],b=>{Pn(()=>e._x_model&&e._x_model.set(Dt(e,t,{target:e},c())))});i(()=>h())}e._x_model={get(){return c()},set(h){u(h)}},e._x_forceModelUpdate=h=>{h===void 0&&typeof n=="string"&&n.match(/\./)&&(h=""),window.fromModel=!0,v(()=>Qi(e,"value",h)),delete window.fromModel},r(()=>{let h=c();t.includes("unintrusive")&&document.activeElement.isSameNode(e)||e._x_forceModelUpdate(h)})});function Dt(e,t,n,r){return v(()=>{if(n instanceof CustomEvent&&n.detail!==void 0)return n.detail!==null&&n.detail!==void 0?n.detail:n.target.value;if(Bn(e))if(Array.isArray(r)){let i=null;return t.includes("number")?i=Nt(n.target.value):t.includes("boolean")?i=Ze(n.target.value):i=n.target.value,n.target.checked?r.includes(i)?r:r.concat([i]):r.filter(o=>!qu(o,i))}else return n.target.checked;else{if(e.tagName.toLowerCase()==="select"&&e.multiple)return t.includes("number")?Array.from(n.target.selectedOptions).map(i=>{let o=i.value||i.text;return Nt(o)}):t.includes("boolean")?Array.from(n.target.selectedOptions).map(i=>{let o=i.value||i.text;return Ze(o)}):Array.from(n.target.selectedOptions).map(i=>i.value||i.text);{let i;return no(e)?n.target.checked?i=n.target.value:i=r:i=n.target.value,t.includes("number")?Nt(i):t.includes("boolean")?Ze(i):t.includes("trim")?i.trim():i}}})}function Nt(e){let t=e?parseFloat(e):null;return Ku(t)?t:e}function qu(e,t){return e==t}function Ku(e){return!Array.isArray(e)&&!isNaN(e)}function xr(e){return e!==null&&typeof e=="object"&&typeof e.get=="function"&&typeof e.set=="function"}O("cloak",e=>queueMicrotask(()=>v(()=>e.removeAttribute(Se("cloak")))));Vi(()=>`[${Se("init")}]`);O("init",Q((e,{expression:t},{evaluate:n})=>typeof t=="string"?!!t.trim()&&n(t,{},!1):n(t,{},!1)));O("text",(e,{expression:t},{effect:n,evaluateLater:r})=>{let i=r(t);n(()=>{i(o=>{v(()=>{e.textContent=o})})})});O("html",(e,{expression:t},{effect:n,evaluateLater:r})=>{let i=r(t);n(()=>{i(o=>{v(()=>{e.innerHTML=o,e._x_ignoreSelf=!0,K(e),delete e._x_ignoreSelf})})})});Dn(Bi(":",$i(Se("bind:"))));var Co=(e,{value:t,modifiers:n,expression:r,original:i},{effect:o,cleanup:s})=>{if(!t){let c={};Gc(c),D(e,r)(l=>{ao(e,l,i)},{scope:c});return}if(t==="key")return zu(e,r);if(e._x_inlineBindings&&e._x_inlineBindings[t]&&e._x_inlineBindings[t].extract)return;let a=D(e,r);o(()=>a(c=>{c===void 0&&typeof r=="string"&&r.match(/\./)&&(c=""),v(()=>Qi(e,t,c,n))})),s(()=>{e._x_undoAddedClasses&&e._x_undoAddedClasses(),e._x_undoAddedStyles&&e._x_undoAddedStyles()})};Co.inline=(e,{value:t,modifiers:n,expression:r})=>{t&&(e._x_inlineBindings||(e._x_inlineBindings={}),e._x_inlineBindings[t]={expression:r,extract:!1})};O("bind",Co);function zu(e,t){e._x_keyExpression=t}zi(()=>`[${Se("data")}]`);O("data",(e,{expression:t},{cleanup:n})=>{if(Vu(e))return;t=t===""?"{}":t;let r={};en(r,e);let i={};Yc(i,r);let o=se(e,t,{scope:i});(o===void 0||o===!0)&&(o={}),en(o,e);let s=we(o);Ci(s);let a=je(e,s);s.init&&se(e,s.init),n(()=>{s.destroy&&se(e,s.destroy),a()})});mt((e,t)=>{e._x_dataStack&&(t._x_dataStack=e._x_dataStack,t.setAttribute("data-has-alpine-state",!0))});function Vu(e){return G?cn?!0:e.hasAttribute("data-has-alpine-state"):!1}O("show",(e,{modifiers:t,expression:n},{effect:r})=>{let i=D(e,n);e._x_doHide||(e._x_doHide=()=>{v(()=>{e.style.setProperty("display","none",t.includes("important")?"important":void 0)})}),e._x_doShow||(e._x_doShow=()=>{v(()=>{e.style.length===1&&e.style.display==="none"?e.removeAttribute("style"):e.style.removeProperty("display")})});let o=()=>{e._x_doHide(),e._x_isShown=!1},s=()=>{e._x_doShow(),e._x_isShown=!0},a=()=>setTimeout(s),c=sn(p=>p?s():o(),p=>{typeof e._x_toggleAndCascadeWithTransitions=="function"?e._x_toggleAndCascadeWithTransitions(e,p,s,o):p?a():o()}),u,l=!0;r(()=>i(p=>{!l&&p===u||(t.includes("immediate")&&(p?a():o()),c(p),u=p,l=!1)}))});O("for",(e,{expression:t},{effect:n,cleanup:r})=>{let i=Ju(t),o=D(e,i.items),s=D(e,e._x_keyExpression||"index");e._x_prevKeys=[],e._x_lookup={},n(()=>Wu(e,i,o,s)),r(()=>{Object.values(e._x_lookup).forEach(a=>v(()=>{ve(a),a.remove()})),delete e._x_prevKeys,delete e._x_lookup})});function Wu(e,t,n,r){let i=s=>typeof s=="object"&&!Array.isArray(s),o=e;n(s=>{Gu(s)&&s>=0&&(s=Array.from(Array(s).keys(),d=>d+1)),s===void 0&&(s=[]);let a=e._x_lookup,c=e._x_prevKeys,u=[],l=[];if(i(s))s=Object.entries(s).map(([d,_])=>{let w=Tr(t,_,d,s);r(E=>{l.includes(E)&&M("Duplicate key on x-for",e),l.push(E)},{scope:{index:d,...w}}),u.push(w)});else for(let d=0;d<s.length;d++){let _=Tr(t,s[d],d,s);r(w=>{l.includes(w)&&M("Duplicate key on x-for",e),l.push(w)},{scope:{index:d,..._}}),u.push(_)}let p=[],h=[],b=[],g=[];for(let d=0;d<c.length;d++){let _=c[d];l.indexOf(_)===-1&&b.push(_)}c=c.filter(d=>!b.includes(d));let m="template";for(let d=0;d<l.length;d++){let _=l[d],w=c.indexOf(_);if(w===-1)c.splice(d,0,_),p.push([m,d]);else if(w!==d){let E=c.splice(d,1)[0],x=c.splice(w-1,1)[0];c.splice(d,0,x),c.splice(w,0,E),h.push([E,x])}else g.push(_);m=_}for(let d=0;d<b.length;d++){let _=b[d];_ in a&&(v(()=>{ve(a[_]),a[_].remove()}),delete a[_])}for(let d=0;d<h.length;d++){let[_,w]=h[d],E=a[_],x=a[w],T=document.createElement("div");v(()=>{x||M('x-for ":key" is undefined or invalid',o,w,a),x.after(T),E.after(x),x._x_currentIfEl&&x.after(x._x_currentIfEl),T.before(E),E._x_currentIfEl&&E.after(E._x_currentIfEl),T.remove()}),x._x_refreshXForScope(u[l.indexOf(w)])}for(let d=0;d<p.length;d++){let[_,w]=p[d],E=_==="template"?o:a[_];E._x_currentIfEl&&(E=E._x_currentIfEl);let x=u[w],T=l[w],N=document.importNode(o.content,!0).firstElementChild,F=we(x);je(N,F,o),N._x_refreshXForScope=ge=>{Object.entries(ge).forEach(([qe,ds])=>{F[qe]=ds})},v(()=>{E.after(N),Q(()=>K(N))()}),typeof T=="object"&&M("x-for key cannot be an object, it must be a string or an integer",o),a[T]=N}for(let d=0;d<g.length;d++)a[g[d]]._x_refreshXForScope(u[l.indexOf(g[d])]);o._x_prevKeys=l})}function Ju(e){let t=/,([^,\}\]]*)(?:,([^,\}\]]*))?$/,n=/^\s*\(|\)\s*$/g,r=/([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/,i=e.match(r);if(!i)return;let o={};o.items=i[2].trim();let s=i[1].replace(n,"").trim(),a=s.match(t);return a?(o.item=s.replace(t,"").trim(),o.index=a[1].trim(),a[2]&&(o.collection=a[2].trim())):o.item=s,o}function Tr(e,t,n,r){let i={};return/^\[.*\]$/.test(e.item)&&Array.isArray(t)?e.item.replace("[","").replace("]","").split(",").map(s=>s.trim()).forEach((s,a)=>{i[s]=t[a]}):/^\{.*\}$/.test(e.item)&&!Array.isArray(t)&&typeof t=="object"?e.item.replace("{","").replace("}","").split(",").map(s=>s.trim()).forEach(s=>{i[s]=t[s]}):i[e.item]=t,e.index&&(i[e.index]=n),e.collection&&(i[e.collection]=r),i}function Gu(e){return!Array.isArray(e)&&!isNaN(e)}function Oo(){}Oo.inline=(e,{expression:t},{cleanup:n})=>{let r=ht(e);r._x_refs||(r._x_refs={}),r._x_refs[t]=e,n(()=>delete r._x_refs[t])};O("ref",Oo);O("if",(e,{expression:t},{effect:n,cleanup:r})=>{e.tagName.toLowerCase()!=="template"&&M("x-if can only be used on a <template> tag",e);let i=D(e,t),o=()=>{if(e._x_currentIfEl)return e._x_currentIfEl;let a=e.content.cloneNode(!0).firstElementChild;return je(a,{},e),v(()=>{e.after(a),Q(()=>K(a))()}),e._x_currentIfEl=a,e._x_undoIf=()=>{v(()=>{ve(a),a.remove()}),delete e._x_currentIfEl},a},s=()=>{e._x_undoIf&&(e._x_undoIf(),delete e._x_undoIf)};n(()=>i(a=>{a?o():s()})),r(()=>e._x_undoIf&&e._x_undoIf())});O("id",(e,{expression:t},{evaluate:n})=>{n(t).forEach(i=>Mu(e,i))});mt((e,t)=>{e._x_ids&&(t._x_ids=e._x_ids)});Dn(Bi("@",$i(Se("on:"))));O("on",Q((e,{value:t,modifiers:n,expression:r},{cleanup:i})=>{let o=r?D(e,r):()=>{};e.tagName.toLowerCase()==="template"&&(e._x_forwardEvents||(e._x_forwardEvents=[]),e._x_forwardEvents.includes(t)||e._x_forwardEvents.push(t));let s=dn(e,t,n,a=>{o(()=>{},{scope:{$event:a},params:[a]})});i(()=>s())}));wt("Collapse","collapse","collapse");wt("Intersect","intersect","intersect");wt("Focus","trap","focus");wt("Mask","mask","mask");function wt(e,t,n){O(t,r=>M(`You can't use [x-${t}] without first installing the "${e}" plugin here: https://alpinejs.dev/plugins/${n}`,r))}Ue.setEvaluator(Ni);Ue.setReactivityEngine({reactive:qn,effect:au,release:cu,raw:A});var Xu=Ue,Io=Xu;const Yu=()=>{};var Cr={};/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ro=function(e){const t=[];let n=0;for(let r=0;r<e.length;r++){let i=e.charCodeAt(r);i<128?t[n++]=i:i<2048?(t[n++]=i>>6|192,t[n++]=i&63|128):(i&64512)===55296&&r+1<e.length&&(e.charCodeAt(r+1)&64512)===56320?(i=65536+((i&1023)<<10)+(e.charCodeAt(++r)&1023),t[n++]=i>>18|240,t[n++]=i>>12&63|128,t[n++]=i>>6&63|128,t[n++]=i&63|128):(t[n++]=i>>12|224,t[n++]=i>>6&63|128,t[n++]=i&63|128)}return t},Qu=function(e){const t=[];let n=0,r=0;for(;n<e.length;){const i=e[n++];if(i<128)t[r++]=String.fromCharCode(i);else if(i>191&&i<224){const o=e[n++];t[r++]=String.fromCharCode((i&31)<<6|o&63)}else if(i>239&&i<365){const o=e[n++],s=e[n++],a=e[n++],c=((i&7)<<18|(o&63)<<12|(s&63)<<6|a&63)-65536;t[r++]=String.fromCharCode(55296+(c>>10)),t[r++]=String.fromCharCode(56320+(c&1023))}else{const o=e[n++],s=e[n++];t[r++]=String.fromCharCode((i&15)<<12|(o&63)<<6|s&63)}}return t.join("")},Do={byteToCharMap_:null,charToByteMap_:null,byteToCharMapWebSafe_:null,charToByteMapWebSafe_:null,ENCODED_VALS_BASE:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",get ENCODED_VALS(){return this.ENCODED_VALS_BASE+"+/="},get ENCODED_VALS_WEBSAFE(){return this.ENCODED_VALS_BASE+"-_."},HAS_NATIVE_SUPPORT:typeof atob=="function",encodeByteArray(e,t){if(!Array.isArray(e))throw Error("encodeByteArray takes an array as a parameter");this.init_();const n=t?this.byteToCharMapWebSafe_:this.byteToCharMap_,r=[];for(let i=0;i<e.length;i+=3){const o=e[i],s=i+1<e.length,a=s?e[i+1]:0,c=i+2<e.length,u=c?e[i+2]:0,l=o>>2,p=(o&3)<<4|a>>4;let h=(a&15)<<2|u>>6,b=u&63;c||(b=64,s||(h=64)),r.push(n[l],n[p],n[h],n[b])}return r.join("")},encodeString(e,t){return this.HAS_NATIVE_SUPPORT&&!t?btoa(e):this.encodeByteArray(Ro(e),t)},decodeString(e,t){return this.HAS_NATIVE_SUPPORT&&!t?atob(e):Qu(this.decodeStringToByteArray(e,t))},decodeStringToByteArray(e,t){this.init_();const n=t?this.charToByteMapWebSafe_:this.charToByteMap_,r=[];for(let i=0;i<e.length;){const o=n[e.charAt(i++)],a=i<e.length?n[e.charAt(i)]:0;++i;const u=i<e.length?n[e.charAt(i)]:64;++i;const p=i<e.length?n[e.charAt(i)]:64;if(++i,o==null||a==null||u==null||p==null)throw new Zu;const h=o<<2|a>>4;if(r.push(h),u!==64){const b=a<<4&240|u>>2;if(r.push(b),p!==64){const g=u<<6&192|p;r.push(g)}}}return r},init_(){if(!this.byteToCharMap_){this.byteToCharMap_={},this.charToByteMap_={},this.byteToCharMapWebSafe_={},this.charToByteMapWebSafe_={};for(let e=0;e<this.ENCODED_VALS.length;e++)this.byteToCharMap_[e]=this.ENCODED_VALS.charAt(e),this.charToByteMap_[this.byteToCharMap_[e]]=e,this.byteToCharMapWebSafe_[e]=this.ENCODED_VALS_WEBSAFE.charAt(e),this.charToByteMapWebSafe_[this.byteToCharMapWebSafe_[e]]=e,e>=this.ENCODED_VALS_BASE.length&&(this.charToByteMap_[this.ENCODED_VALS_WEBSAFE.charAt(e)]=e,this.charToByteMapWebSafe_[this.ENCODED_VALS.charAt(e)]=e)}}};class Zu extends Error{constructor(){super(...arguments),this.name="DecodeBase64StringError"}}const el=function(e){const t=Ro(e);return Do.encodeByteArray(t,!0)},No=function(e){return el(e).replace(/\./g,"")},tl=function(e){try{return Do.decodeString(e,!0)}catch(t){console.error("base64Decode failed: ",t)}return null};/**
 * @license
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function nl(){if(typeof self<"u")return self;if(typeof window<"u")return window;if(typeof global<"u")return global;throw new Error("Unable to locate global object.")}/**
 * @license
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const rl=()=>nl().__FIREBASE_DEFAULTS__,il=()=>{if(typeof process>"u"||typeof Cr>"u")return;const e=Cr.__FIREBASE_DEFAULTS__;if(e)return JSON.parse(e)},ol=()=>{if(typeof document>"u")return;let e;try{e=document.cookie.match(/__FIREBASE_DEFAULTS__=([^;]+)/)}catch{return}const t=e&&tl(e[1]);return t&&JSON.parse(t)},sl=()=>{try{return Yu()||rl()||il()||ol()}catch(e){console.info(`Unable to get __FIREBASE_DEFAULTS__ due to: ${e}`);return}},ko=()=>{var e;return(e=sl())==null?void 0:e.config};/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class al{constructor(){this.reject=()=>{},this.resolve=()=>{},this.promise=new Promise((t,n)=>{this.resolve=t,this.reject=n})}wrapCallback(t){return(n,r)=>{n?this.reject(n):this.resolve(r),typeof t=="function"&&(this.promise.catch(()=>{}),t.length===1?t(n):t(n,r))}}}function Po(){try{return typeof indexedDB=="object"}catch{return!1}}function Mo(){return new Promise((e,t)=>{try{let n=!0;const r="validate-browser-context-for-indexeddb-analytics-module",i=self.indexedDB.open(r);i.onsuccess=()=>{i.result.close(),n||self.indexedDB.deleteDatabase(r),e(!0)},i.onupgradeneeded=()=>{n=!1},i.onerror=()=>{var o;t(((o=i.error)==null?void 0:o.message)||"")}}catch(n){t(n)}})}function cl(){return!(typeof navigator>"u"||!navigator.cookieEnabled)}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ul="FirebaseError";class xe extends Error{constructor(t,n,r){super(n),this.code=t,this.customData=r,this.name=ul,Object.setPrototypeOf(this,xe.prototype),Error.captureStackTrace&&Error.captureStackTrace(this,Et.prototype.create)}}class Et{constructor(t,n,r){this.service=t,this.serviceName=n,this.errors=r}create(t,...n){const r=n[0]||{},i=`${this.service}/${t}`,o=this.errors[t],s=o?ll(o,r):"Error",a=`${this.serviceName}: ${s} (${i}).`;return new xe(i,a,r)}}function ll(e,t){return e.replace(fl,(n,r)=>{const i=t[r];return i!=null?String(i):`<${r}?>`})}const fl=/\{\$([^}]+)}/g;function pn(e,t){if(e===t)return!0;const n=Object.keys(e),r=Object.keys(t);for(const i of n){if(!r.includes(i))return!1;const o=e[i],s=t[i];if(Or(o)&&Or(s)){if(!pn(o,s))return!1}else if(o!==s)return!1}for(const i of r)if(!n.includes(i))return!1;return!0}function Or(e){return e!==null&&typeof e=="object"}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Kn(e){return e&&e._delegate?e._delegate:e}class Y{constructor(t,n,r){this.name=t,this.instanceFactory=n,this.type=r,this.multipleInstances=!1,this.serviceProps={},this.instantiationMode="LAZY",this.onInstanceCreated=null}setInstantiationMode(t){return this.instantiationMode=t,this}setMultipleInstances(t){return this.multipleInstances=t,this}setServiceProps(t){return this.serviceProps=t,this}setInstanceCreatedCallback(t){return this.onInstanceCreated=t,this}}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ee="[DEFAULT]";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class dl{constructor(t,n){this.name=t,this.container=n,this.component=null,this.instances=new Map,this.instancesDeferred=new Map,this.instancesOptions=new Map,this.onInitCallbacks=new Map}get(t){const n=this.normalizeInstanceIdentifier(t);if(!this.instancesDeferred.has(n)){const r=new al;if(this.instancesDeferred.set(n,r),this.isInitialized(n)||this.shouldAutoInitialize())try{const i=this.getOrInitializeService({instanceIdentifier:n});i&&r.resolve(i)}catch{}}return this.instancesDeferred.get(n).promise}getImmediate(t){const n=this.normalizeInstanceIdentifier(t==null?void 0:t.identifier),r=(t==null?void 0:t.optional)??!1;if(this.isInitialized(n)||this.shouldAutoInitialize())try{return this.getOrInitializeService({instanceIdentifier:n})}catch(i){if(r)return null;throw i}else{if(r)return null;throw Error(`Service ${this.name} is not available`)}}getComponent(){return this.component}setComponent(t){if(t.name!==this.name)throw Error(`Mismatching Component ${t.name} for Provider ${this.name}.`);if(this.component)throw Error(`Component for ${this.name} has already been provided`);if(this.component=t,!!this.shouldAutoInitialize()){if(hl(t))try{this.getOrInitializeService({instanceIdentifier:ee})}catch{}for(const[n,r]of this.instancesDeferred.entries()){const i=this.normalizeInstanceIdentifier(n);try{const o=this.getOrInitializeService({instanceIdentifier:i});r.resolve(o)}catch{}}}}clearInstance(t=ee){this.instancesDeferred.delete(t),this.instancesOptions.delete(t),this.instances.delete(t)}async delete(){const t=Array.from(this.instances.values());await Promise.all([...t.filter(n=>"INTERNAL"in n).map(n=>n.INTERNAL.delete()),...t.filter(n=>"_delete"in n).map(n=>n._delete())])}isComponentSet(){return this.component!=null}isInitialized(t=ee){return this.instances.has(t)}getOptions(t=ee){return this.instancesOptions.get(t)||{}}initialize(t={}){const{options:n={}}=t,r=this.normalizeInstanceIdentifier(t.instanceIdentifier);if(this.isInitialized(r))throw Error(`${this.name}(${r}) has already been initialized`);if(!this.isComponentSet())throw Error(`Component ${this.name} has not been registered yet`);const i=this.getOrInitializeService({instanceIdentifier:r,options:n});for(const[o,s]of this.instancesDeferred.entries()){const a=this.normalizeInstanceIdentifier(o);r===a&&s.resolve(i)}return i}onInit(t,n){const r=this.normalizeInstanceIdentifier(n),i=this.onInitCallbacks.get(r)??new Set;i.add(t),this.onInitCallbacks.set(r,i);const o=this.instances.get(r);return o&&t(o,r),()=>{i.delete(t)}}invokeOnInitCallbacks(t,n){const r=this.onInitCallbacks.get(n);if(r)for(const i of r)try{i(t,n)}catch{}}getOrInitializeService({instanceIdentifier:t,options:n={}}){let r=this.instances.get(t);if(!r&&this.component&&(r=this.component.instanceFactory(this.container,{instanceIdentifier:pl(t),options:n}),this.instances.set(t,r),this.instancesOptions.set(t,n),this.invokeOnInitCallbacks(r,t),this.component.onInstanceCreated))try{this.component.onInstanceCreated(this.container,t,r)}catch{}return r||null}normalizeInstanceIdentifier(t=ee){return this.component?this.component.multipleInstances?t:ee:t}shouldAutoInitialize(){return!!this.component&&this.component.instantiationMode!=="EXPLICIT"}}function pl(e){return e===ee?void 0:e}function hl(e){return e.instantiationMode==="EAGER"}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class gl{constructor(t){this.name=t,this.providers=new Map}addComponent(t){const n=this.getProvider(t.name);if(n.isComponentSet())throw new Error(`Component ${t.name} has already been registered with ${this.name}`);n.setComponent(t)}addOrOverwriteComponent(t){this.getProvider(t.name).isComponentSet()&&this.providers.delete(t.name),this.addComponent(t)}getProvider(t){if(this.providers.has(t))return this.providers.get(t);const n=new dl(t,this);return this.providers.set(t,n),n}getProviders(){return Array.from(this.providers.values())}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */var S;(function(e){e[e.DEBUG=0]="DEBUG",e[e.VERBOSE=1]="VERBOSE",e[e.INFO=2]="INFO",e[e.WARN=3]="WARN",e[e.ERROR=4]="ERROR",e[e.SILENT=5]="SILENT"})(S||(S={}));const ml={debug:S.DEBUG,verbose:S.VERBOSE,info:S.INFO,warn:S.WARN,error:S.ERROR,silent:S.SILENT},bl=S.INFO,_l={[S.DEBUG]:"log",[S.VERBOSE]:"log",[S.INFO]:"info",[S.WARN]:"warn",[S.ERROR]:"error"},yl=(e,t,...n)=>{if(t<e.logLevel)return;const r=new Date().toISOString(),i=_l[t];if(i)console[i](`[${r}]  ${e.name}:`,...n);else throw new Error(`Attempted to log a message with an invalid logType (value: ${t})`)};class wl{constructor(t){this.name=t,this._logLevel=bl,this._logHandler=yl,this._userLogHandler=null}get logLevel(){return this._logLevel}set logLevel(t){if(!(t in S))throw new TypeError(`Invalid value "${t}" assigned to \`logLevel\``);this._logLevel=t}setLogLevel(t){this._logLevel=typeof t=="string"?ml[t]:t}get logHandler(){return this._logHandler}set logHandler(t){if(typeof t!="function")throw new TypeError("Value assigned to `logHandler` must be a function");this._logHandler=t}get userLogHandler(){return this._userLogHandler}set userLogHandler(t){this._userLogHandler=t}debug(...t){this._userLogHandler&&this._userLogHandler(this,S.DEBUG,...t),this._logHandler(this,S.DEBUG,...t)}log(...t){this._userLogHandler&&this._userLogHandler(this,S.VERBOSE,...t),this._logHandler(this,S.VERBOSE,...t)}info(...t){this._userLogHandler&&this._userLogHandler(this,S.INFO,...t),this._logHandler(this,S.INFO,...t)}warn(...t){this._userLogHandler&&this._userLogHandler(this,S.WARN,...t),this._logHandler(this,S.WARN,...t)}error(...t){this._userLogHandler&&this._userLogHandler(this,S.ERROR,...t),this._logHandler(this,S.ERROR,...t)}}const El=(e,t)=>t.some(n=>e instanceof n);let Ir,Rr;function Sl(){return Ir||(Ir=[IDBDatabase,IDBObjectStore,IDBIndex,IDBCursor,IDBTransaction])}function Al(){return Rr||(Rr=[IDBCursor.prototype.advance,IDBCursor.prototype.continue,IDBCursor.prototype.continuePrimaryKey])}const Bo=new WeakMap,hn=new WeakMap,$o=new WeakMap,kt=new WeakMap,zn=new WeakMap;function vl(e){const t=new Promise((n,r)=>{const i=()=>{e.removeEventListener("success",o),e.removeEventListener("error",s)},o=()=>{n(q(e.result)),i()},s=()=>{r(e.error),i()};e.addEventListener("success",o),e.addEventListener("error",s)});return t.then(n=>{n instanceof IDBCursor&&Bo.set(n,e)}).catch(()=>{}),zn.set(t,e),t}function xl(e){if(hn.has(e))return;const t=new Promise((n,r)=>{const i=()=>{e.removeEventListener("complete",o),e.removeEventListener("error",s),e.removeEventListener("abort",s)},o=()=>{n(),i()},s=()=>{r(e.error||new DOMException("AbortError","AbortError")),i()};e.addEventListener("complete",o),e.addEventListener("error",s),e.addEventListener("abort",s)});hn.set(e,t)}let gn={get(e,t,n){if(e instanceof IDBTransaction){if(t==="done")return hn.get(e);if(t==="objectStoreNames")return e.objectStoreNames||$o.get(e);if(t==="store")return n.objectStoreNames[1]?void 0:n.objectStore(n.objectStoreNames[0])}return q(e[t])},set(e,t,n){return e[t]=n,!0},has(e,t){return e instanceof IDBTransaction&&(t==="done"||t==="store")?!0:t in e}};function Tl(e){gn=e(gn)}function Cl(e){return e===IDBDatabase.prototype.transaction&&!("objectStoreNames"in IDBTransaction.prototype)?function(t,...n){const r=e.call(Pt(this),t,...n);return $o.set(r,t.sort?t.sort():[t]),q(r)}:Al().includes(e)?function(...t){return e.apply(Pt(this),t),q(Bo.get(this))}:function(...t){return q(e.apply(Pt(this),t))}}function Ol(e){return typeof e=="function"?Cl(e):(e instanceof IDBTransaction&&xl(e),El(e,Sl())?new Proxy(e,gn):e)}function q(e){if(e instanceof IDBRequest)return vl(e);if(kt.has(e))return kt.get(e);const t=Ol(e);return t!==e&&(kt.set(e,t),zn.set(t,e)),t}const Pt=e=>zn.get(e);function St(e,t,{blocked:n,upgrade:r,blocking:i,terminated:o}={}){const s=indexedDB.open(e,t),a=q(s);return r&&s.addEventListener("upgradeneeded",c=>{r(q(s.result),c.oldVersion,c.newVersion,q(s.transaction),c)}),n&&s.addEventListener("blocked",c=>n(c.oldVersion,c.newVersion,c)),a.then(c=>{o&&c.addEventListener("close",()=>o()),i&&c.addEventListener("versionchange",u=>i(u.oldVersion,u.newVersion,u))}).catch(()=>{}),a}function Mt(e,{blocked:t}={}){const n=indexedDB.deleteDatabase(e);return t&&n.addEventListener("blocked",r=>t(r.oldVersion,r)),q(n).then(()=>{})}const Il=["get","getKey","getAll","getAllKeys","count"],Rl=["put","add","delete","clear"],Bt=new Map;function Dr(e,t){if(!(e instanceof IDBDatabase&&!(t in e)&&typeof t=="string"))return;if(Bt.get(t))return Bt.get(t);const n=t.replace(/FromIndex$/,""),r=t!==n,i=Rl.includes(n);if(!(n in(r?IDBIndex:IDBObjectStore).prototype)||!(i||Il.includes(n)))return;const o=async function(s,...a){const c=this.transaction(s,i?"readwrite":"readonly");let u=c.store;return r&&(u=u.index(a.shift())),(await Promise.all([u[n](...a),i&&c.done]))[0]};return Bt.set(t,o),o}Tl(e=>({...e,get:(t,n,r)=>Dr(t,n)||e.get(t,n,r),has:(t,n)=>!!Dr(t,n)||e.has(t,n)}));/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class Dl{constructor(t){this.container=t}getPlatformInfoString(){return this.container.getProviders().map(n=>{if(Nl(n)){const r=n.getImmediate();return`${r.library}/${r.version}`}else return null}).filter(n=>n).join(" ")}}function Nl(e){const t=e.getComponent();return(t==null?void 0:t.type)==="VERSION"}const mn="@firebase/app",Nr="0.14.3";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const z=new wl("@firebase/app"),kl="@firebase/app-compat",Pl="@firebase/analytics-compat",Ml="@firebase/analytics",Bl="@firebase/app-check-compat",$l="@firebase/app-check",Ll="@firebase/auth",Fl="@firebase/auth-compat",jl="@firebase/database",Hl="@firebase/data-connect",Ul="@firebase/database-compat",ql="@firebase/functions",Kl="@firebase/functions-compat",zl="@firebase/installations",Vl="@firebase/installations-compat",Wl="@firebase/messaging",Jl="@firebase/messaging-compat",Gl="@firebase/performance",Xl="@firebase/performance-compat",Yl="@firebase/remote-config",Ql="@firebase/remote-config-compat",Zl="@firebase/storage",ef="@firebase/storage-compat",tf="@firebase/firestore",nf="@firebase/ai",rf="@firebase/firestore-compat",of="firebase";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const bn="[DEFAULT]",sf={[mn]:"fire-core",[kl]:"fire-core-compat",[Ml]:"fire-analytics",[Pl]:"fire-analytics-compat",[$l]:"fire-app-check",[Bl]:"fire-app-check-compat",[Ll]:"fire-auth",[Fl]:"fire-auth-compat",[jl]:"fire-rtdb",[Hl]:"fire-data-connect",[Ul]:"fire-rtdb-compat",[ql]:"fire-fn",[Kl]:"fire-fn-compat",[zl]:"fire-iid",[Vl]:"fire-iid-compat",[Wl]:"fire-fcm",[Jl]:"fire-fcm-compat",[Gl]:"fire-perf",[Xl]:"fire-perf-compat",[Yl]:"fire-rc",[Ql]:"fire-rc-compat",[Zl]:"fire-gcs",[ef]:"fire-gcs-compat",[tf]:"fire-fst",[rf]:"fire-fst-compat",[nf]:"fire-vertex","fire-js":"fire-js",[of]:"fire-js-all"};/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const st=new Map,af=new Map,_n=new Map;function kr(e,t){try{e.container.addComponent(t)}catch(n){z.debug(`Component ${t.name} failed to register with FirebaseApp ${e.name}`,n)}}function fe(e){const t=e.name;if(_n.has(t))return z.debug(`There were multiple attempts to register component ${t}.`),!1;_n.set(t,e);for(const n of st.values())kr(n,e);for(const n of af.values())kr(n,e);return!0}function Vn(e,t){const n=e.container.getProvider("heartbeat").getImmediate({optional:!0});return n&&n.triggerHeartbeat(),e.container.getProvider(t)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const cf={"no-app":"No Firebase App '{$appName}' has been created - call initializeApp() first","bad-app-name":"Illegal App name: '{$appName}'","duplicate-app":"Firebase App named '{$appName}' already exists with different options or config","app-deleted":"Firebase App named '{$appName}' already deleted","server-app-deleted":"Firebase Server App has been deleted","no-options":"Need to provide options, when not being deployed to hosting via source.","invalid-app-argument":"firebase.{$appName}() takes either no argument or a Firebase App instance.","invalid-log-argument":"First argument to `onLog` must be null or a function.","idb-open":"Error thrown when opening IndexedDB. Original error: {$originalErrorMessage}.","idb-get":"Error thrown when reading from IndexedDB. Original error: {$originalErrorMessage}.","idb-set":"Error thrown when writing to IndexedDB. Original error: {$originalErrorMessage}.","idb-delete":"Error thrown when deleting from IndexedDB. Original error: {$originalErrorMessage}.","finalization-registry-not-supported":"FirebaseServerApp deleteOnDeref field defined but the JS runtime does not support FinalizationRegistry.","invalid-server-app-environment":"FirebaseServerApp is not for use in browser environments."},W=new Et("app","Firebase",cf);/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class uf{constructor(t,n,r){this._isDeleted=!1,this._options={...t},this._config={...n},this._name=n.name,this._automaticDataCollectionEnabled=n.automaticDataCollectionEnabled,this._container=r,this.container.addComponent(new Y("app",()=>this,"PUBLIC"))}get automaticDataCollectionEnabled(){return this.checkDestroyed(),this._automaticDataCollectionEnabled}set automaticDataCollectionEnabled(t){this.checkDestroyed(),this._automaticDataCollectionEnabled=t}get name(){return this.checkDestroyed(),this._name}get options(){return this.checkDestroyed(),this._options}get config(){return this.checkDestroyed(),this._config}get container(){return this._container}get isDeleted(){return this._isDeleted}set isDeleted(t){this._isDeleted=t}checkDestroyed(){if(this.isDeleted)throw W.create("app-deleted",{appName:this._name})}}function Lo(e,t={}){let n=e;typeof t!="object"&&(t={name:t});const r={name:bn,automaticDataCollectionEnabled:!0,...t},i=r.name;if(typeof i!="string"||!i)throw W.create("bad-app-name",{appName:String(i)});if(n||(n=ko()),!n)throw W.create("no-options");const o=st.get(i);if(o){if(pn(n,o.options)&&pn(r,o.config))return o;throw W.create("duplicate-app",{appName:i})}const s=new gl(i);for(const c of _n.values())s.addComponent(c);const a=new uf(n,r,s);return st.set(i,a),a}function lf(e=bn){const t=st.get(e);if(!t&&e===bn&&ko())return Lo();if(!t)throw W.create("no-app",{appName:e});return t}function J(e,t,n){let r=sf[e]??e;n&&(r+=`-${n}`);const i=r.match(/\s|\//),o=t.match(/\s|\//);if(i||o){const s=[`Unable to register library "${r}" with version "${t}":`];i&&s.push(`library name "${r}" contains illegal characters (whitespace or "/")`),i&&o&&s.push("and"),o&&s.push(`version name "${t}" contains illegal characters (whitespace or "/")`),z.warn(s.join(" "));return}fe(new Y(`${r}-version`,()=>({library:r,version:t}),"VERSION"))}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ff="firebase-heartbeat-database",df=1,Me="firebase-heartbeat-store";let $t=null;function Fo(){return $t||($t=St(ff,df,{upgrade:(e,t)=>{switch(t){case 0:try{e.createObjectStore(Me)}catch(n){console.warn(n)}}}}).catch(e=>{throw W.create("idb-open",{originalErrorMessage:e.message})})),$t}async function pf(e){try{const n=(await Fo()).transaction(Me),r=await n.objectStore(Me).get(jo(e));return await n.done,r}catch(t){if(t instanceof xe)z.warn(t.message);else{const n=W.create("idb-get",{originalErrorMessage:t==null?void 0:t.message});z.warn(n.message)}}}async function Pr(e,t){try{const r=(await Fo()).transaction(Me,"readwrite");await r.objectStore(Me).put(t,jo(e)),await r.done}catch(n){if(n instanceof xe)z.warn(n.message);else{const r=W.create("idb-set",{originalErrorMessage:n==null?void 0:n.message});z.warn(r.message)}}}function jo(e){return`${e.name}!${e.options.appId}`}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const hf=1024,gf=30;class mf{constructor(t){this.container=t,this._heartbeatsCache=null;const n=this.container.getProvider("app").getImmediate();this._storage=new _f(n),this._heartbeatsCachePromise=this._storage.read().then(r=>(this._heartbeatsCache=r,r))}async triggerHeartbeat(){var t,n;try{const i=this.container.getProvider("platform-logger").getImmediate().getPlatformInfoString(),o=Mr();if(((t=this._heartbeatsCache)==null?void 0:t.heartbeats)==null&&(this._heartbeatsCache=await this._heartbeatsCachePromise,((n=this._heartbeatsCache)==null?void 0:n.heartbeats)==null)||this._heartbeatsCache.lastSentHeartbeatDate===o||this._heartbeatsCache.heartbeats.some(s=>s.date===o))return;if(this._heartbeatsCache.heartbeats.push({date:o,agent:i}),this._heartbeatsCache.heartbeats.length>gf){const s=yf(this._heartbeatsCache.heartbeats);this._heartbeatsCache.heartbeats.splice(s,1)}return this._storage.overwrite(this._heartbeatsCache)}catch(r){z.warn(r)}}async getHeartbeatsHeader(){var t;try{if(this._heartbeatsCache===null&&await this._heartbeatsCachePromise,((t=this._heartbeatsCache)==null?void 0:t.heartbeats)==null||this._heartbeatsCache.heartbeats.length===0)return"";const n=Mr(),{heartbeatsToSend:r,unsentEntries:i}=bf(this._heartbeatsCache.heartbeats),o=No(JSON.stringify({version:2,heartbeats:r}));return this._heartbeatsCache.lastSentHeartbeatDate=n,i.length>0?(this._heartbeatsCache.heartbeats=i,await this._storage.overwrite(this._heartbeatsCache)):(this._heartbeatsCache.heartbeats=[],this._storage.overwrite(this._heartbeatsCache)),o}catch(n){return z.warn(n),""}}}function Mr(){return new Date().toISOString().substring(0,10)}function bf(e,t=hf){const n=[];let r=e.slice();for(const i of e){const o=n.find(s=>s.agent===i.agent);if(o){if(o.dates.push(i.date),Br(n)>t){o.dates.pop();break}}else if(n.push({agent:i.agent,dates:[i.date]}),Br(n)>t){n.pop();break}r=r.slice(1)}return{heartbeatsToSend:n,unsentEntries:r}}class _f{constructor(t){this.app=t,this._canUseIndexedDBPromise=this.runIndexedDBEnvironmentCheck()}async runIndexedDBEnvironmentCheck(){return Po()?Mo().then(()=>!0).catch(()=>!1):!1}async read(){if(await this._canUseIndexedDBPromise){const n=await pf(this.app);return n!=null&&n.heartbeats?n:{heartbeats:[]}}else return{heartbeats:[]}}async overwrite(t){if(await this._canUseIndexedDBPromise){const r=await this.read();return Pr(this.app,{lastSentHeartbeatDate:t.lastSentHeartbeatDate??r.lastSentHeartbeatDate,heartbeats:t.heartbeats})}else return}async add(t){if(await this._canUseIndexedDBPromise){const r=await this.read();return Pr(this.app,{lastSentHeartbeatDate:t.lastSentHeartbeatDate??r.lastSentHeartbeatDate,heartbeats:[...r.heartbeats,...t.heartbeats]})}else return}}function Br(e){return No(JSON.stringify({version:2,heartbeats:e})).length}function yf(e){if(e.length===0)return-1;let t=0,n=e[0].date;for(let r=1;r<e.length;r++)e[r].date<n&&(n=e[r].date,t=r);return t}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function wf(e){fe(new Y("platform-logger",t=>new Dl(t),"PRIVATE")),fe(new Y("heartbeat",t=>new mf(t),"PRIVATE")),J(mn,Nr,e),J(mn,Nr,"esm2020"),J("fire-js","")}wf("");var Ef="firebase",Sf="12.3.0";/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */J(Ef,Sf,"app");const Ho="@firebase/installations",Wn="0.6.19";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Uo=1e4,qo=`w:${Wn}`,Ko="FIS_v2",Af="https://firebaseinstallations.googleapis.com/v1",vf=60*60*1e3,xf="installations",Tf="Installations";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Cf={"missing-app-config-values":'Missing App configuration value: "{$valueName}"',"not-registered":"Firebase Installation is not registered.","installation-not-found":"Firebase Installation not found.","request-failed":'{$requestName} request failed with error "{$serverCode} {$serverStatus}: {$serverMessage}"',"app-offline":"Could not process request. Application offline.","delete-pending-registration":"Can't delete installation while there is a pending registration request."},de=new Et(xf,Tf,Cf);function zo(e){return e instanceof xe&&e.code.includes("request-failed")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Vo({projectId:e}){return`${Af}/projects/${e}/installations`}function Wo(e){return{token:e.token,requestStatus:2,expiresIn:If(e.expiresIn),creationTime:Date.now()}}async function Jo(e,t){const r=(await t.json()).error;return de.create("request-failed",{requestName:e,serverCode:r.code,serverMessage:r.message,serverStatus:r.status})}function Go({apiKey:e}){return new Headers({"Content-Type":"application/json",Accept:"application/json","x-goog-api-key":e})}function Of(e,{refreshToken:t}){const n=Go(e);return n.append("Authorization",Rf(t)),n}async function Xo(e){const t=await e();return t.status>=500&&t.status<600?e():t}function If(e){return Number(e.replace("s","000"))}function Rf(e){return`${Ko} ${e}`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Df({appConfig:e,heartbeatServiceProvider:t},{fid:n}){const r=Vo(e),i=Go(e),o=t.getImmediate({optional:!0});if(o){const u=await o.getHeartbeatsHeader();u&&i.append("x-firebase-client",u)}const s={fid:n,authVersion:Ko,appId:e.appId,sdkVersion:qo},a={method:"POST",headers:i,body:JSON.stringify(s)},c=await Xo(()=>fetch(r,a));if(c.ok){const u=await c.json();return{fid:u.fid||n,registrationStatus:2,refreshToken:u.refreshToken,authToken:Wo(u.authToken)}}else throw await Jo("Create Installation",c)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Yo(e){return new Promise(t=>{setTimeout(t,e)})}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Nf(e){return btoa(String.fromCharCode(...e)).replace(/\+/g,"-").replace(/\//g,"_")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const kf=/^[cdef][\w-]{21}$/,yn="";function Pf(){try{const e=new Uint8Array(17);(self.crypto||self.msCrypto).getRandomValues(e),e[0]=112+e[0]%16;const n=Mf(e);return kf.test(n)?n:yn}catch{return yn}}function Mf(e){return Nf(e).substr(0,22)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function At(e){return`${e.appName}!${e.appId}`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Qo=new Map;function Zo(e,t){const n=At(e);es(n,t),Bf(n,t)}function es(e,t){const n=Qo.get(e);if(n)for(const r of n)r(t)}function Bf(e,t){const n=$f();n&&n.postMessage({key:e,fid:t}),Lf()}let re=null;function $f(){return!re&&"BroadcastChannel"in self&&(re=new BroadcastChannel("[Firebase] FID Change"),re.onmessage=e=>{es(e.data.key,e.data.fid)}),re}function Lf(){Qo.size===0&&re&&(re.close(),re=null)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ff="firebase-installations-database",jf=1,pe="firebase-installations-store";let Lt=null;function Jn(){return Lt||(Lt=St(Ff,jf,{upgrade:(e,t)=>{switch(t){case 0:e.createObjectStore(pe)}}})),Lt}async function at(e,t){const n=At(e),i=(await Jn()).transaction(pe,"readwrite"),o=i.objectStore(pe),s=await o.get(n);return await o.put(t,n),await i.done,(!s||s.fid!==t.fid)&&Zo(e,t.fid),t}async function ts(e){const t=At(e),r=(await Jn()).transaction(pe,"readwrite");await r.objectStore(pe).delete(t),await r.done}async function vt(e,t){const n=At(e),i=(await Jn()).transaction(pe,"readwrite"),o=i.objectStore(pe),s=await o.get(n),a=t(s);return a===void 0?await o.delete(n):await o.put(a,n),await i.done,a&&(!s||s.fid!==a.fid)&&Zo(e,a.fid),a}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Gn(e){let t;const n=await vt(e.appConfig,r=>{const i=Hf(r),o=Uf(e,i);return t=o.registrationPromise,o.installationEntry});return n.fid===yn?{installationEntry:await t}:{installationEntry:n,registrationPromise:t}}function Hf(e){const t=e||{fid:Pf(),registrationStatus:0};return ns(t)}function Uf(e,t){if(t.registrationStatus===0){if(!navigator.onLine){const i=Promise.reject(de.create("app-offline"));return{installationEntry:t,registrationPromise:i}}const n={fid:t.fid,registrationStatus:1,registrationTime:Date.now()},r=qf(e,n);return{installationEntry:n,registrationPromise:r}}else return t.registrationStatus===1?{installationEntry:t,registrationPromise:Kf(e)}:{installationEntry:t}}async function qf(e,t){try{const n=await Df(e,t);return at(e.appConfig,n)}catch(n){throw zo(n)&&n.customData.serverCode===409?await ts(e.appConfig):await at(e.appConfig,{fid:t.fid,registrationStatus:0}),n}}async function Kf(e){let t=await $r(e.appConfig);for(;t.registrationStatus===1;)await Yo(100),t=await $r(e.appConfig);if(t.registrationStatus===0){const{installationEntry:n,registrationPromise:r}=await Gn(e);return r||n}return t}function $r(e){return vt(e,t=>{if(!t)throw de.create("installation-not-found");return ns(t)})}function ns(e){return zf(e)?{fid:e.fid,registrationStatus:0}:e}function zf(e){return e.registrationStatus===1&&e.registrationTime+Uo<Date.now()}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Vf({appConfig:e,heartbeatServiceProvider:t},n){const r=Wf(e,n),i=Of(e,n),o=t.getImmediate({optional:!0});if(o){const u=await o.getHeartbeatsHeader();u&&i.append("x-firebase-client",u)}const s={installation:{sdkVersion:qo,appId:e.appId}},a={method:"POST",headers:i,body:JSON.stringify(s)},c=await Xo(()=>fetch(r,a));if(c.ok){const u=await c.json();return Wo(u)}else throw await Jo("Generate Auth Token",c)}function Wf(e,{fid:t}){return`${Vo(e)}/${t}/authTokens:generate`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Xn(e,t=!1){let n;const r=await vt(e.appConfig,o=>{if(!rs(o))throw de.create("not-registered");const s=o.authToken;if(!t&&Xf(s))return o;if(s.requestStatus===1)return n=Jf(e,t),o;{if(!navigator.onLine)throw de.create("app-offline");const a=Qf(o);return n=Gf(e,a),a}});return n?await n:r.authToken}async function Jf(e,t){let n=await Lr(e.appConfig);for(;n.authToken.requestStatus===1;)await Yo(100),n=await Lr(e.appConfig);const r=n.authToken;return r.requestStatus===0?Xn(e,t):r}function Lr(e){return vt(e,t=>{if(!rs(t))throw de.create("not-registered");const n=t.authToken;return Zf(n)?{...t,authToken:{requestStatus:0}}:t})}async function Gf(e,t){try{const n=await Vf(e,t),r={...t,authToken:n};return await at(e.appConfig,r),n}catch(n){if(zo(n)&&(n.customData.serverCode===401||n.customData.serverCode===404))await ts(e.appConfig);else{const r={...t,authToken:{requestStatus:0}};await at(e.appConfig,r)}throw n}}function rs(e){return e!==void 0&&e.registrationStatus===2}function Xf(e){return e.requestStatus===2&&!Yf(e)}function Yf(e){const t=Date.now();return t<e.creationTime||e.creationTime+e.expiresIn<t+vf}function Qf(e){const t={requestStatus:1,requestTime:Date.now()};return{...e,authToken:t}}function Zf(e){return e.requestStatus===1&&e.requestTime+Uo<Date.now()}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function ed(e){const t=e,{installationEntry:n,registrationPromise:r}=await Gn(t);return r?r.catch(console.error):Xn(t).catch(console.error),n.fid}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function td(e,t=!1){const n=e;return await nd(n),(await Xn(n,t)).token}async function nd(e){const{registrationPromise:t}=await Gn(e);t&&await t}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function rd(e){if(!e||!e.options)throw Ft("App Configuration");if(!e.name)throw Ft("App Name");const t=["projectId","apiKey","appId"];for(const n of t)if(!e.options[n])throw Ft(n);return{appName:e.name,projectId:e.options.projectId,apiKey:e.options.apiKey,appId:e.options.appId}}function Ft(e){return de.create("missing-app-config-values",{valueName:e})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const is="installations",id="installations-internal",od=e=>{const t=e.getProvider("app").getImmediate(),n=rd(t),r=Vn(t,"heartbeat");return{app:t,appConfig:n,heartbeatServiceProvider:r,_delete:()=>Promise.resolve()}},sd=e=>{const t=e.getProvider("app").getImmediate(),n=Vn(t,is).getImmediate();return{getId:()=>ed(n),getToken:i=>td(n,i)}};function ad(){fe(new Y(is,od,"PUBLIC")),fe(new Y(id,sd,"PRIVATE"))}ad();J(Ho,Wn);J(Ho,Wn,"esm2020");/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const cd="/firebase-messaging-sw.js",ud="/firebase-cloud-messaging-push-scope",os="BDOU99-h67HcA6JeFXHbSNMu7e2yNNu3RzoMj8TM4W88jITfq7ZmPvIM1Iv-4_l2LxQcYwhqby2xGpWwzjfAnG4",ld="https://fcmregistrations.googleapis.com/v1",ss="google.c.a.c_id",fd="google.c.a.c_l",dd="google.c.a.ts",pd="google.c.a.e",Fr=1e4;var jr;(function(e){e[e.DATA_MESSAGE=1]="DATA_MESSAGE",e[e.DISPLAY_NOTIFICATION=3]="DISPLAY_NOTIFICATION"})(jr||(jr={}));/**
 * @license
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */var Be;(function(e){e.PUSH_RECEIVED="push-received",e.NOTIFICATION_CLICKED="notification-clicked"})(Be||(Be={}));/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function U(e){const t=new Uint8Array(e);return btoa(String.fromCharCode(...t)).replace(/=/g,"").replace(/\+/g,"-").replace(/\//g,"_")}function hd(e){const t="=".repeat((4-e.length%4)%4),n=(e+t).replace(/\-/g,"+").replace(/_/g,"/"),r=atob(n),i=new Uint8Array(r.length);for(let o=0;o<r.length;++o)i[o]=r.charCodeAt(o);return i}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const jt="fcm_token_details_db",gd=5,Hr="fcm_token_object_Store";async function md(e){if("databases"in indexedDB&&!(await indexedDB.databases()).map(o=>o.name).includes(jt))return null;let t=null;return(await St(jt,gd,{upgrade:async(r,i,o,s)=>{if(i<2||!r.objectStoreNames.contains(Hr))return;const a=s.objectStore(Hr),c=await a.index("fcmSenderId").get(e);if(await a.clear(),!!c){if(i===2){const u=c;if(!u.auth||!u.p256dh||!u.endpoint)return;t={token:u.fcmToken,createTime:u.createTime??Date.now(),subscriptionOptions:{auth:u.auth,p256dh:u.p256dh,endpoint:u.endpoint,swScope:u.swScope,vapidKey:typeof u.vapidKey=="string"?u.vapidKey:U(u.vapidKey)}}}else if(i===3){const u=c;t={token:u.fcmToken,createTime:u.createTime,subscriptionOptions:{auth:U(u.auth),p256dh:U(u.p256dh),endpoint:u.endpoint,swScope:u.swScope,vapidKey:U(u.vapidKey)}}}else if(i===4){const u=c;t={token:u.fcmToken,createTime:u.createTime,subscriptionOptions:{auth:U(u.auth),p256dh:U(u.p256dh),endpoint:u.endpoint,swScope:u.swScope,vapidKey:U(u.vapidKey)}}}}}})).close(),await Mt(jt),await Mt("fcm_vapid_details_db"),await Mt("undefined"),bd(t)?t:null}function bd(e){if(!e||!e.subscriptionOptions)return!1;const{subscriptionOptions:t}=e;return typeof e.createTime=="number"&&e.createTime>0&&typeof e.token=="string"&&e.token.length>0&&typeof t.auth=="string"&&t.auth.length>0&&typeof t.p256dh=="string"&&t.p256dh.length>0&&typeof t.endpoint=="string"&&t.endpoint.length>0&&typeof t.swScope=="string"&&t.swScope.length>0&&typeof t.vapidKey=="string"&&t.vapidKey.length>0}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const _d="firebase-messaging-database",yd=1,$e="firebase-messaging-store";let Ht=null;function as(){return Ht||(Ht=St(_d,yd,{upgrade:(e,t)=>{switch(t){case 0:e.createObjectStore($e)}}})),Ht}async function wd(e){const t=cs(e),r=await(await as()).transaction($e).objectStore($e).get(t);if(r)return r;{const i=await md(e.appConfig.senderId);if(i)return await Yn(e,i),i}}async function Yn(e,t){const n=cs(e),i=(await as()).transaction($e,"readwrite");return await i.objectStore($e).put(t,n),await i.done,t}function cs({appConfig:e}){return e.appId}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ed={"missing-app-config-values":'Missing App configuration value: "{$valueName}"',"only-available-in-window":"This method is available in a Window context.","only-available-in-sw":"This method is available in a service worker context.","permission-default":"The notification permission was not granted and dismissed instead.","permission-blocked":"The notification permission was not granted and blocked instead.","unsupported-browser":"This browser doesn't support the API's required to use the Firebase SDK.","indexed-db-unsupported":"This browser doesn't support indexedDb.open() (ex. Safari iFrame, Firefox Private Browsing, etc)","failed-service-worker-registration":"We are unable to register the default service worker. {$browserErrorMessage}","token-subscribe-failed":"A problem occurred while subscribing the user to FCM: {$errorInfo}","token-subscribe-no-token":"FCM returned no token when subscribing the user to push.","token-unsubscribe-failed":"A problem occurred while unsubscribing the user from FCM: {$errorInfo}","token-update-failed":"A problem occurred while updating the user from FCM: {$errorInfo}","token-update-no-token":"FCM returned no token when updating the user to push.","use-sw-after-get-token":"The useServiceWorker() method may only be called once and must be called before calling getToken() to ensure your service worker is used.","invalid-sw-registration":"The input to useServiceWorker() must be a ServiceWorkerRegistration.","invalid-bg-handler":"The input to setBackgroundMessageHandler() must be a function.","invalid-vapid-key":"The public VAPID key must be a string.","use-vapid-key-after-get-token":"The usePublicVapidKey() method may only be called once and must be called before calling getToken() to ensure your VAPID key is used."},R=new Et("messaging","Messaging",Ed);/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Sd(e,t){const n=await Zn(e),r=us(t),i={method:"POST",headers:n,body:JSON.stringify(r)};let o;try{o=await(await fetch(Qn(e.appConfig),i)).json()}catch(s){throw R.create("token-subscribe-failed",{errorInfo:s==null?void 0:s.toString()})}if(o.error){const s=o.error.message;throw R.create("token-subscribe-failed",{errorInfo:s})}if(!o.token)throw R.create("token-subscribe-no-token");return o.token}async function Ad(e,t){const n=await Zn(e),r=us(t.subscriptionOptions),i={method:"PATCH",headers:n,body:JSON.stringify(r)};let o;try{o=await(await fetch(`${Qn(e.appConfig)}/${t.token}`,i)).json()}catch(s){throw R.create("token-update-failed",{errorInfo:s==null?void 0:s.toString()})}if(o.error){const s=o.error.message;throw R.create("token-update-failed",{errorInfo:s})}if(!o.token)throw R.create("token-update-no-token");return o.token}async function vd(e,t){const r={method:"DELETE",headers:await Zn(e)};try{const o=await(await fetch(`${Qn(e.appConfig)}/${t}`,r)).json();if(o.error){const s=o.error.message;throw R.create("token-unsubscribe-failed",{errorInfo:s})}}catch(i){throw R.create("token-unsubscribe-failed",{errorInfo:i==null?void 0:i.toString()})}}function Qn({projectId:e}){return`${ld}/projects/${e}/registrations`}async function Zn({appConfig:e,installations:t}){const n=await t.getToken();return new Headers({"Content-Type":"application/json",Accept:"application/json","x-goog-api-key":e.apiKey,"x-goog-firebase-installations-auth":`FIS ${n}`})}function us({p256dh:e,auth:t,endpoint:n,vapidKey:r}){const i={web:{endpoint:n,auth:t,p256dh:e}};return r!==os&&(i.web.applicationPubKey=r),i}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const xd=7*24*60*60*1e3;async function Td(e){const t=await Od(e.swRegistration,e.vapidKey),n={vapidKey:e.vapidKey,swScope:e.swRegistration.scope,endpoint:t.endpoint,auth:U(t.getKey("auth")),p256dh:U(t.getKey("p256dh"))},r=await wd(e.firebaseDependencies);if(r){if(Id(r.subscriptionOptions,n))return Date.now()>=r.createTime+xd?Cd(e,{token:r.token,createTime:Date.now(),subscriptionOptions:n}):r.token;try{await vd(e.firebaseDependencies,r.token)}catch(i){console.warn(i)}return Ur(e.firebaseDependencies,n)}else return Ur(e.firebaseDependencies,n)}async function Cd(e,t){try{const n=await Ad(e.firebaseDependencies,t),r={...t,token:n,createTime:Date.now()};return await Yn(e.firebaseDependencies,r),n}catch(n){throw n}}async function Ur(e,t){const r={token:await Sd(e,t),createTime:Date.now(),subscriptionOptions:t};return await Yn(e,r),r.token}async function Od(e,t){const n=await e.pushManager.getSubscription();return n||e.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:hd(t)})}function Id(e,t){const n=t.vapidKey===e.vapidKey,r=t.endpoint===e.endpoint,i=t.auth===e.auth,o=t.p256dh===e.p256dh;return n&&r&&i&&o}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function qr(e){const t={from:e.from,collapseKey:e.collapse_key,messageId:e.fcmMessageId};return Rd(t,e),Dd(t,e),Nd(t,e),t}function Rd(e,t){if(!t.notification)return;e.notification={};const n=t.notification.title;n&&(e.notification.title=n);const r=t.notification.body;r&&(e.notification.body=r);const i=t.notification.image;i&&(e.notification.image=i);const o=t.notification.icon;o&&(e.notification.icon=o)}function Dd(e,t){t.data&&(e.data=t.data)}function Nd(e,t){var i,o,s,a;if(!t.fcmOptions&&!((i=t.notification)!=null&&i.click_action))return;e.fcmOptions={};const n=((o=t.fcmOptions)==null?void 0:o.link)??((s=t.notification)==null?void 0:s.click_action);n&&(e.fcmOptions.link=n);const r=(a=t.fcmOptions)==null?void 0:a.analytics_label;r&&(e.fcmOptions.analyticsLabel=r)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function kd(e){return typeof e=="object"&&!!e&&ss in e}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Pd(e){if(!e||!e.options)throw Ut("App Configuration Object");if(!e.name)throw Ut("App Name");const t=["projectId","apiKey","appId","messagingSenderId"],{options:n}=e;for(const r of t)if(!n[r])throw Ut(r);return{appName:e.name,projectId:n.projectId,apiKey:n.apiKey,appId:n.appId,senderId:n.messagingSenderId}}function Ut(e){return R.create("missing-app-config-values",{valueName:e})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class Md{constructor(t,n,r){this.deliveryMetricsExportedToBigQueryEnabled=!1,this.onBackgroundMessageHandler=null,this.onMessageHandler=null,this.logEvents=[],this.isLogServiceStarted=!1;const i=Pd(t);this.firebaseDependencies={app:t,appConfig:i,installations:n,analyticsProvider:r}}_delete(){return Promise.resolve()}}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Bd(e){try{e.swRegistration=await navigator.serviceWorker.register(cd,{scope:ud}),e.swRegistration.update().catch(()=>{}),await $d(e.swRegistration)}catch(t){throw R.create("failed-service-worker-registration",{browserErrorMessage:t==null?void 0:t.message})}}async function $d(e){return new Promise((t,n)=>{const r=setTimeout(()=>n(new Error(`Service worker not registered after ${Fr} ms`)),Fr),i=e.installing||e.waiting;e.active?(clearTimeout(r),t()):i?i.onstatechange=o=>{var s;((s=o.target)==null?void 0:s.state)==="activated"&&(i.onstatechange=null,clearTimeout(r),t())}:(clearTimeout(r),n(new Error("No incoming service worker found.")))})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Ld(e,t){if(!t&&!e.swRegistration&&await Bd(e),!(!t&&e.swRegistration)){if(!(t instanceof ServiceWorkerRegistration))throw R.create("invalid-sw-registration");e.swRegistration=t}}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Fd(e,t){t?e.vapidKey=t:e.vapidKey||(e.vapidKey=os)}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function ls(e,t){if(!navigator)throw R.create("only-available-in-window");if(Notification.permission==="default"&&await Notification.requestPermission(),Notification.permission!=="granted")throw R.create("permission-blocked");return await Fd(e,t==null?void 0:t.vapidKey),await Ld(e,t==null?void 0:t.serviceWorkerRegistration),Td(e)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function jd(e,t,n){const r=Hd(t);(await e.firebaseDependencies.analyticsProvider.get()).logEvent(r,{message_id:n[ss],message_name:n[fd],message_time:n[dd],message_device_time:Math.floor(Date.now()/1e3)})}function Hd(e){switch(e){case Be.NOTIFICATION_CLICKED:return"notification_open";case Be.PUSH_RECEIVED:return"notification_foreground";default:throw new Error}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Ud(e,t){const n=t.data;if(!n.isFirebaseMessaging)return;e.onMessageHandler&&n.messageType===Be.PUSH_RECEIVED&&(typeof e.onMessageHandler=="function"?e.onMessageHandler(qr(n)):e.onMessageHandler.next(qr(n)));const r=n.data;kd(r)&&r[pd]==="1"&&await jd(e,n.messageType,r)}const Kr="@firebase/messaging",zr="0.12.23";/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const qd=e=>{const t=new Md(e.getProvider("app").getImmediate(),e.getProvider("installations-internal").getImmediate(),e.getProvider("analytics-internal"));return navigator.serviceWorker.addEventListener("message",n=>Ud(t,n)),t},Kd=e=>{const t=e.getProvider("messaging").getImmediate();return{getToken:r=>ls(t,r)}};function zd(){fe(new Y("messaging",qd,"PUBLIC")),fe(new Y("messaging-internal",Kd,"PRIVATE")),J(Kr,zr),J(Kr,zr,"esm2020")}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Vd(){try{await Mo()}catch{return!1}return typeof window<"u"&&Po()&&cl()&&"serviceWorker"in navigator&&"PushManager"in window&&"Notification"in window&&"fetch"in window&&ServiceWorkerRegistration.prototype.hasOwnProperty("showNotification")&&PushSubscription.prototype.hasOwnProperty("getKey")}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Wd(e,t){if(!navigator)throw R.create("only-available-in-window");return e.onMessageHandler=t,()=>{e.onMessageHandler=null}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Jd(e=lf()){return Vd().then(t=>{if(!t)throw R.create("unsupported-browser")},t=>{throw R.create("indexed-db-unsupported")}),Vn(Kn(e),"messaging").getImmediate()}async function Gd(e,t){return e=Kn(e),ls(e,t)}function Xd(e,t){return e=Kn(e),Wd(e,t)}zd();window.Alpine=Io;Io.start();const Yd={apiKey:"AIzaSyBQCPTwnybdtLNUwNCzDDA23TLt3pD5zP4",authDomain:"omdachina25.firebaseapp.com",projectId:"omdachina25",storageBucket:"omdachina25.firebasestorage.app",messagingSenderId:"1031143486488",appId:"212ca723-6015-43de-8e66-6f24d0defbd9",measurementId:"G-G9TLSKJ92H"};OneSignal.init({appId:"212ca723-6015-43de-8e66-6f24d0defbd9"});const Qd=Lo(Yd),fs=Jd(Qd),Vr=new Set;"serviceWorker"in navigator&&navigator.serviceWorker.getRegistrations().then(e=>{const t=e.map(n=>n.scope.includes("firebase-messaging-sw.js")||n.scope.includes("service-worker")?n.unregister().then(()=>console.log(`Unregistered old SW: ${n.scope}`)):Promise.resolve());Promise.all(t).then(()=>{navigator.serviceWorker.register("/firebase-messaging-sw.js").then(()=>console.log("✅ Firebase Service Worker registered")).catch(n=>console.error("SW registration failed:",n))})}).catch(e=>console.error("Error checking SW registrations:",e));window.addEventListener("DOMContentLoaded",()=>{if(localStorage.getItem("fcm_token_saved")){console.log("FCM Token already saved");return}Notification.requestPermission().then(e=>{console.log("Permission:",e),e==="granted"&&Gd(fs,{vapidKey:"BB168ueRnlIhDY0r5lrLD7pvQydPk467794F97CWizmwnvzxAWtlx3fuZ9NQtxc0QeokXdnBjiYoiINBIRvCQiY"}).then(t=>{t?(console.log("FCM Token:",t),fetch("/save-fcm-token",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify({token:t})}).then(n=>n.json()).then(n=>{console.log("Save token response:",n),localStorage.setItem("fcm_token_saved","true")}).catch(n=>console.error("Error saving token:",n))):console.warn("No FCM registration token available.")}).catch(t=>console.error("Error getting token:",t))})});window.__FIREBASE_ONMESSAGE_REGISTERED__||(window.__FIREBASE_ONMESSAGE_REGISTERED__=!0,Xd(fs,e=>{var n,r,i,o,s,a,c,u,l,p,h,b;const t=(n=e.data)!=null&&n.report_id?`${e.data.type}_${e.data.report_id}`:`${e.data.type}_${e.data.place_id}`;if(Vr.has(t)){console.log(`Duplicate notification ignored: ${t}`);return}if((r=e.data)!=null&&r.type&&((i=e.data)!=null&&i.report_id||(o=e.data)!=null&&o.place_id)&&Vr.add(t),console.log("📩 Message received:",e),console.log("🔎 Data:",e.data),Swal.fire({title:((s=e.notification)==null?void 0:s.title)||"إشعار جديد",text:((a=e.notification)==null?void 0:a.body)||"",icon:"info",confirmButtonText:"موافق"}),(((c=e.data)==null?void 0:c.type)==="place_added"||((u=e.data)==null?void 0:u.type)==="place_favorited")&&((l=document.querySelector('meta[name="user-role"]'))==null?void 0:l.getAttribute("content"))==="admin"){const m=e.data.type==="place_added"?"🎉 مكان جديد!":"❤️ مكان تم إضافته للمفضلة!";Swal.fire({title:m,text:`المكان: ${e.data.place_name}`,icon:"success",confirmButtonText:"عرض",showCancelButton:!0,cancelButtonText:"لاحقاً"}).then(d=>{d.isConfirmed&&(window.location.href=`/admin/places/${e.data.place_id}`)}),tp(e)}((p=e.data)==null?void 0:p.type)==="admin_place_report"&&Zd(e),((h=e.data)==null?void 0:h.type)==="place_report"&&np(e),((b=e.data)==null?void 0:b.type)==="review_report"&&ep(e)}));function Zd(e){const t=document.querySelector(".notifications-container");if(!t){console.warn("Notifications container not found");return}if(t.querySelector(`[data-id="admin-report-${e.data.report_id}"]`)){console.log(`Duplicate admin report notification ignored: ${e.data.report_id}`);return}const n=`
        <div class="flex justify-between items-center pb-4 border-b border-dashed border-purple-400 dark:border-purple-600 notification-item"
             data-id="admin-report-${e.data.report_id}">
            <p>🚨 بلاغ جديد عن المكان: ${e.data.place_name}</p>
            <i class="ph ph-flag text-purple-500"></i>
        </div>
    `;t.insertAdjacentHTML("afterbegin",n)}function ep(e){const t=document.querySelector(".notifications-container");if(!t){console.warn("Notifications container not found");return}if(t.querySelector(`[data-id="review-report-${e.data.report_id}"]`)){console.log(`Duplicate review report notification ignored: ${e.data.report_id}`);return}t.insertAdjacentHTML("afterbegin",`
        <div class="flex justify-between items-center pb-4 border-b border-dashed border-yellow-400 dark:border-yellow-600 notification-item"
             data-id="review-report-${e.data.report_id}">
            <p>🚨 تم الإبلاغ عن تقييم في مكانك: ${e.notification.body}</p>
            <i class="ph ph-warning text-yellow-500"></i>
        </div>
    `)}function tp(e){const t=document.querySelector(".notifications-container");if(!t){console.warn("Notifications container not found");return}if(t.querySelector(`[data-id="place-${e.data.place_id}"]`)){console.log(`Duplicate place notification ignored: ${e.data.place_id}`);return}const n=e.data.type==="place_added"?"border-green-400 dark:border-green-600":"border-red-400 dark:border-red-600",r=e.data.type==="place_added"?`🎉 تم إضافة المكان: ${e.data.place_name}`:`❤️ تم إضافة المكان للمفضلة: ${e.data.place_name}`;t.insertAdjacentHTML("afterbegin",`
        <div class="flex justify-between items-center pb-4 border-b border-dashed ${n} notification-item"
             data-id="place-${e.data.place_id}">
            <p>${r}</p>
            <i class="ph ph-x"></i>
        </div>
    `)}function np(e){const t=document.querySelector(".notifications-container");if(!t){console.warn("Notifications container not found");return}if(t.querySelector(`[data-id="report-against-${e.data.report_id}"]`)){console.log(`Duplicate place report notification ignored: ${e.data.report_id}`);return}t.insertAdjacentHTML("afterbegin",`
        <div class="flex justify-between items-center pb-4 border-b border-dashed border-red-400 dark:border-red-600 notification-item"
             data-id="report-against-${e.data.report_id}">
            <p>تم الإبلاغ عن مكانك: ${e.notification.body}</p>
            <i class="ph ph-warning text-red-500"></i>
        </div>
    `)}
