!function(){var t=document.querySelectorAll("html.logged-in .c-excerpt__header");if(t.length){var e=document.getElementsByTagName("head")[0].querySelector('link[rel="https://api.w.org/"]').getAttribute("href"),n="".concat(e,"wp/v2/posts/"),o=function(t){t.preventDefault();var e=t.target.closest(".c-excerpt").getAttribute("class").match(/post-([\d]+)/);fetch("".concat(n).concat(e[1]),{method:"DELETE",headers:{"X-WP-Nonce":sht_theme.nonce}}).then((function(t){return t.json()})).then((function(e){e.data&&e.data.status&&200!==e.data.status?console.error(e.message):t.target.closest(".c-excerpt").remove()})).catch((function(t){console.error("Something went wrong.",t)}))};t.forEach((function(t){var e=document.createElement("button");e.innerHTML="Move this post to the trash",e.classList.add("o-button"),e.addEventListener("click",o),t.appendChild(e)}))}}();