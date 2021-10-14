if (!!document.querySelector('[data-mhm-redbubble]')) {
    const script = document.createElement('script');
    script.setAttribute('src', 'https://www.redbubble.com/assets/external_portfolio.js');
    script.addEventListener('load', () => {
        new RBExternalPortfolio('www.redbubble.com', 'mhowellsmead', 6, 4).renderIframe();
    });
    document.head.appendChild(script);
}
