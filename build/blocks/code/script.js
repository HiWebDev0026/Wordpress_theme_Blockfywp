(()=>{"use strict";var e={n:t=>{var o=t&&t.__esModule?()=>t.default:()=>t;return e.d(o,{a:o}),o},d:(t,o)=>{for(var n in o)e.o(o,n)&&!e.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:o[n]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const t=window.wp.i18n,o=window.wp.domReady;e.n(o)()((()=>{document.querySelectorAll(".wp-block-code").forEach((e=>{const o=e.getElementsByTagName("code")[0];let n=document.createElement("textarea"),l=document.createElement("button"),a=document.createElement("div"),r=document.createElement("span");n.value=o.innerText,l.className="copy-code-button",l.type="button",l.innerText=(0,t.__)("Copy","blockify"),a.className="tooltip",r.className="tooltip-text",r.innerText=(0,t.__)("Copy to clipboard","blockify"),a.appendChild(r),e.insertBefore(l,e.firstChild),e.insertBefore(a,l),l.addEventListener("click",(()=>{var e,o;n.select(),n.setSelectionRange(0,99999),null===(e=navigator)||void 0===e||null===(o=e.clipboard)||void 0===o||o.writeText(n.value),alert((0,t.__)("Copied ","blockify")+n.value)}))}))}))})();