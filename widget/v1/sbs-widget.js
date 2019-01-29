// Pull status variable from status.json
var requestURL = '/status.json';
var request = new XMLHttpRequest();
request.open('GET', requestURL);
request.responseType = 'json';
request.send();
request.onload = function() {
    var json = request.response;
    
    // Insert content into widget div
    var widgetHTML = '<style>@import url(\'https://fonts.googleapis.com/css?family=Roboto\');</style><a href="https://www.skywaybridgestatus.com" style="text-decoration: none;"><div id="sbs-widget__container" style="width:100%; border:1px solid grey; border-radius:5px; box-shadow: 0px 2px 6px rgba(0,0,0,0.3); text-align:center; background-color:#F9FBFB;"><div id="sbs-widget__branding" style="background-color: #FFFFFF; width: 100%; padding: 10px 0; border-bottom: #979797 1px; box-shadow: 0 4px 2px -2px rgba(0,0,0,0.5); border-radius: 5px 5px 0px 0px;"><svg id="sbs-widget__logo" title="Skyway Bridge Status" alt="Skyway Bridge Status logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width:150px;display:block; margin-left:auto; margin-right: auto; max-width: 90vw;" viewBox="0 0 2246.3 364.5"><defs><linearGradient id="linear-gradient" x1="329.25" y1="360" x2="329.25" y2="32.5" gradientTransform="matrix(1, 0, 0, -1, 0, 397)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#03caff"/><stop offset="0.45" stop-color="#03c8fe"/><stop offset="0.69" stop-color="#03c0fb"/><stop offset="0.87" stop-color="#02b3f6"/><stop offset="1" stop-color="#02a4f0"/></linearGradient><clipPath id="clip-path"><path d="M361.9,29.7,379,45.4a51.73,51.73,0,0,0-5.1,4.2Z" style="fill:none"/></clipPath><clipPath id="clip-path-40"><path d="M400.2,12.5l6.9,22.1c-1.1.1-2.2.3-3.3.4s-2.2.4-3.3.6Z" style="fill:none"/></clipPath><clipPath id="clip-path-79"><path d="M430.6,37l11.3-20.3-5.1,22.6C434.8,38.5,432.8,37.7,430.6,37Z" style="fill:none"/></clipPath><clipPath id="clip-path-118"><path d="M468.5,110l20.3,11.3-22.6-5.1A46.18,46.18,0,0,0,468.5,110Z" style="fill:none"/></clipPath><clipPath id="clip-path-157"><path d="M460.2,58.3a51.73,51.73,0,0,0-4.2-5.1l19.9-11.9Z" style="fill:none"/></clipPath><clipPath id="clip-path-196"><path d="M470.9,86.5c-.1-1.1-.3-2.2-.4-3.3l-.6-3.3,23.2-.4Z" style="fill:none"/></clipPath><radialGradient id="radial-gradient" cx="413.06" cy="304.56" r="48.37" gradientTransform="matrix(1, 0, 0, -1, 0, 397)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffd600"/><stop offset="0.31" stop-color="#ffd000"/><stop offset="0.71" stop-color="#ffc000"/><stop offset="1" stop-color="#ffb000"/></radialGradient></defs><title>Skyway Bridge Status logo</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path d="M897.1,104.8c-4-11.3-14.2-21-44.2-21-16.6,0-33.4,4.2-33.4,15.8,0,5.4,3.1,11.1,28.2,14.2l29.8,4.5c28.2,4.3,44.9,15.3,44.9,36.4,0,29.8-28.4,40.9-62,40.9-54.1,0-67.2-26.7-70.2-36.2l23.7-7.5c4.5,9.2,13.9,22.5,47.1,22.5,20.1,0,36.7-6.6,36.7-17.5,0-8.1-9.4-13.5-27.4-15.8l-30.2-4.2c-29.1-4-45.4-16.6-45.4-35.9,0-37.8,49-37.8,58.8-37.8,54.2,0,63.6,25.1,66.7,33.8Z"/><path d="M940,66.5h21.5v71.2l47.1-38.3h30.8l-39.7,31.5,42.1,61.5H1016L983.4,144l-22,17.7v30.8H939.9V66.5Z"/><path d="M1050.8,203.2a50.91,50.91,0,0,0,13.2,2.1c17.7,0,23.6-7.5,23.6-14.6,0-4.3-.9-8.5-3.8-14.6l-37.3-76.8h23.6l31.5,67.9,31.5-67.9h23.6l-48.4,100.5c-8.3,17.5-21.8,24.4-38.8,24.4a56.87,56.87,0,0,1-18.7-2.8V203.2Z"/><path d="M1241.4,127.3l-23.7,65.2h-20.3l-36.7-93.1h22.5l24.4,65.3,24.3-65.3H1251l24.6,65.3,24.8-65.3h21.8l-36.4,93.1h-20.6Z"/><path d="M1427,177.4c0,6.2.3,12.5,1.7,15.1h-22a42.47,42.47,0,0,1-1.2-9.4c-9,5.2-22.4,12.5-40.7,12.5-12.3,0-36-5.2-36-28.1,0-31.4,46.8-35.9,76.8-37.6v-4.2c0-7.1-6.4-12.1-24.1-12.1-19.8,0-23.9,7.3-25.1,12.3H1334c5.2-25.3,30-29.6,47.3-29.6,44.9,0,45.8,21.8,45.8,34.7v46.4Zm-21.5-31.9a170.07,170.07,0,0,0-33.4,4.7c-13.3,3.1-19.6,7.6-19.8,15.8-.2,8,5,13,15.6,13,16.3,0,29.3-7.1,37.6-12.1V145.5Z"/><path d="M1445.6,203.2a50.91,50.91,0,0,0,13.2,2.1c17.7,0,23.6-7.5,23.6-14.6,0-4.3-.9-8.5-3.8-14.6l-37.3-76.8h23.6l31.5,67.9,31.5-67.9h23.6l-48.4,100.5c-8.3,17.5-21.8,24.4-38.8,24.4a56.87,56.87,0,0,1-18.7-2.8V203.2Z"/><path d="M1631.9,66.5h75.9c29.6,0,49.4,8.3,49.4,32.2,0,15.9-7.8,21.8-14.6,26.2,8.8,3.8,19.4,14.6,19.4,31,0,23.7-18.9,36.6-49.6,36.6h-80.6V66.5Zm77.4,49.7c16.1,0,23.2-4,23.2-14.6s-7.1-14.7-23.2-14.7h-52.9v29.3Zm.7,55.8c15.6,0,27.4-3.1,27.4-18,0-13.2-10.7-17.3-27.4-17.3h-53.6v35.4H1710Z"/><path d="M1782.6,99.4h21.5v13.9h.5c4.7-7.6,14-17,32.6-17a57.14,57.14,0,0,1,7.6.3v23.2a48.33,48.33,0,0,0-13.2-1.7c-27.4.2-27.4,18.4-27.6,25v49.4h-21.5V99.4Z"/><path d="M1861.3,63.4h21.5V82.5h-21.5Zm0,36h21.5v93.1h-21.5Z"/><path d="M1987.6,180.5c-4.9,4.7-15.6,15.1-36.9,15.1-26.3,0-49-18.7-49-50.3,0-28.2,19.2-49,49.9-49,17.9,0,26.5,6.2,35.7,12.8V66.5h21.5v126h-21.1v-12Zm-.3-53c-6.6-5.4-15.4-12.8-31-12.8-16.5,0-32.8,10.4-32.8,31.4,0,20.5,15.4,31.2,32.1,31.2,14.7,0,23.4-7.1,31.7-13.5Z"/><path d="M2133.4,114.5c-1.9-.5-5.4-1.7-7.8-1.4a18.36,18.36,0,0,0-6.9,1.7,27.55,27.55,0,0,1,4.3,15.4c0,25.3-22.5,34.3-47.1,34.3a59.93,59.93,0,0,1-19.6-2.9c-2.4,1.6-5.9,4.2-5.9,7.5s2.1,5.5,20.8,5.4h29.3c21,.7,33.1,6.8,33.1,21.3,0,22.2-32.4,28.6-60.5,28.6-26,0-48.5-5.2-48.5-20.6,0-11.1,9.9-12.7,18.7-14.4v-.3c-8-.7-14-5-14-14.4s8.8-16.5,16.3-17.5v-.3c-10.4-5.7-15.4-14.9-15.4-26.7,0-27.4,25.1-33.8,48-33.8,16.3,0,25.8,4.2,32.2,8.5,3.3-3.5,10.2-10.1,19.6-10.1h3.5v19.7Zm-73,79.2c-5,0-12.3,1.4-12.3,6.8,0,7.6,10.1,8.5,27,8.5s34.8-1.9,34.8-9.4c0-6.4-3.8-6.1-27.6-5.9Zm41.4-63.4c0-13.9-14.2-18-25.6-18-11.8,0-25,4.2-25,18.2,0,14.6,13.3,18.2,24.8,18.2S2101.8,144,2101.8,130.3Z"/><path d="M2244.6,164.6c-1.6,7.6-14,31-48.5,31-33.3,0-53.2-20.8-53.2-49.9,0-26.3,17.3-49.4,51.6-49.4,35,.3,51.8,22,51.8,55.6h-81.6c.9,5.9,4.2,25.3,30.7,26.3,13.5,0,22.5-6.4,25.7-13.7h23.5Zm-21.1-29.3c-3.3-15.8-14-21.7-29.5-21.7-11.3,0-24.3,3.8-28.6,21.7Z"/><path d="M799.3,328.6c6.3,8.4,16.7,22.1,49.3,22.1,16.7,0,39.6-4.8,39.6-21.6,0-33-94.6-4-94.6-48.1,0-23.1,21.3-32.5,50.9-32.5,28.7,0,46.3,11.8,53.7,22.2l-9.6,7.8c-4.5-5.1-14.9-19-44.5-19-21.8,0-37.2,5.7-37.2,19.4,0,32.8,94.6,1.5,94.6,50.2,0,18.2-17.6,33.3-54.5,33.3-35.5,0-48.7-14.8-57.9-25.1Z"/><path d="M969.8,291.9h-31v47.2c0,8.5,3.7,12.7,16,12.7,5.8,0,10.6-1,17.2-2.4v10.4c-8.7,1.3-14.8,2.2-19.7,2.2-25.5,0-25.5-15.5-25.5-21.8V291.8H910.2V281.5h16.6v-26h12.1v26h31v10.4Z"/><path d="M1062.3,347.6a66.94,66.94,0,0,0,1.3,12.1h-12.1a43,43,0,0,1-1.5-9.4,70.14,70.14,0,0,1-39,11.8c-12.8,0-31.8-3.6-31.8-23.7,0-27,40.5-28.1,70.9-31.6v-3c0-10.6-12.7-14.6-25.1-14.6-20.7,0-28.1,8.7-31.9,13.1L984,296c4.5-5.5,13-16.7,40.2-16.7,17.8,0,38.1,5.2,38.1,25.2Zm-12.1-31.1c-35.5,3.4-59.4,6.7-59.4,21.8,0,12.2,13.7,13.9,19.7,13.9,16.9,0,31.9-8.1,39.7-12.2V316.5Z"/><path d="M1135.6,291.9h-31v47.2c0,8.5,3.7,12.7,16,12.7,5.8,0,10.6-1,17.2-2.4v10.4c-8.7,1.3-14.8,2.2-19.7,2.2-25.5,0-25.5-15.5-25.5-21.8V291.8H1076V281.5h16.6v-26h12.1v26h31v10.4Z"/><path d="M1228.8,359.7h-12.1V348.4c-8.2,7.2-19,13.7-32.8,13.7-9.7,0-32.2-2.2-32.2-29V281.6h12.1v49.1c-.3,18.5,13.1,21,21.6,21,13.3,0,24.3-8.2,31.3-15.7V281.5h12.1Z"/><path d="M1253,335.4c7.6,9.6,19,16.4,35.4,16.4,12.8,0,24.5-4,24.5-13.3,0-22.1-64.9-3.3-64.9-35.5,0-17.8,18.2-23.7,34.6-23.7,26.3,0,35.8,11.2,39.9,16.9l-8.2,7.5c-6.4-8.2-16.4-14-31.8-14-14.3,0-22.4,4.5-22.4,12.7,0,20.2,64.9,1.9,64.9,35.4,0,17.9-17.6,24.5-37.6,24.5-17.3,0-31.6-4.9-43.3-18.5Z"/><path d="M658.5,364.5H0c0-3,2.9-9.5,8.2-19.3.1-.1.1-.2.2-.3s6.9-10.8,8.4-13.3a5.2,5.2,0,0,0,.3-.5C63.6,255.7,197.9,87.2,329.3,37c6.8,2.6,13.7,5.5,20.5,8.8s13.5,6.7,20.5,10.5h0A57.76,57.76,0,0,0,357,92.1a60.38,60.38,0,0,0,.7,9.4,56.1,56.1,0,0,0,103.5,20c80.6,69.9,149.1,159.7,179.9,209.4a5.2,5.2,0,0,0,.3.5c1.6,2.5,8.7,13.8,8.7,13.8l.1.1a137.35,137.35,0,0,1,6.7,13.3A21.79,21.79,0,0,1,658.5,364.5Z" style="fill:url(#linear-gradient)"/><polygon points="215.2 281.8 195.8 310.8 200.3 310.5 215.4 287.9 215.7 287.6 215.5 281.4 215.2 281.8" style="fill:#fff"/><polygon points="320.4 303 324.9 302.8 223.8 176.6 223.5 167.5 211.7 168.3 212 176 211.5 176.7 118.8 315.5 123.3 315.3 211.8 182.8 212.2 182.1 213.2 211.5 212.9 211.9 144.5 313.9 149 313.7 213.1 218 213.4 217.6 214.5 251.8 214.3 246.5 214 246.9 170.2 312.4 174.6 312.1 214.2 253 214.6 252.6 216.4 309.5 228.1 308.8 225.1 216.9 225.3 217.5 294.8 304.6 299.3 304.3 225.1 211.4 224.9 210.8 225.1 215.9 224 182.6 320.4 303" style="fill:#fff"/><polygon points="226.1 245.8 226.3 251.9 226.4 252.4 269.2 306.2 273.7 305.9 226.2 246.3 226.1 245.8" style="fill:#fff"/><polygon points="227.2 280.7 227.4 286.8 227.6 287.4 243.6 307.8 248.1 307.5 227.4 281.3 227.2 280.7" style="fill:#fff"/><polygon points="445 176.7 444.5 176 444.8 168.3 433.1 167.5 432.8 176.6 331.7 302.8 336.1 303 432.6 182.6 431.6 210.8 431.5 211.4 357.2 304.3 361.7 304.6 431.3 217.5 431.4 216.9 430.4 249 430.5 245.8 430.3 246.3 382.8 305.9 387.3 306.2 430.1 252.4 430.3 251.9 428.4 308.8 440.1 309.5 440.8 287.6 441.1 287.9 456.3 310.5 460.8 310.8 441.3 281.8 441 281.4 442 252.6 442.3 253 481.9 312.1 486.4 312.4 442.5 246.9 442.2 246.5 444.3 182.1 444.8 182.8 533.2 315.3 537.7 315.5 445 176.7" style="fill:#fff"/><polygon points="443.3 211.5 443.1 217.6 443.5 218 507.5 313.7 512 313.9 443.7 211.9 443.3 211.5" style="fill:#fff"/><polygon points="429.1 286.8 429.3 280.7 429.1 281.3 408.4 307.5 412.9 307.8 428.9 287.4 429.1 286.8" style="fill:#fff"/><path d="M650.1,345.3a1,1,0,0,1-.4-.1c-.6-.1-.9-.3-1.5-.4l-9-2.1v21.8h-15V339.6c-9-2.2-21-4.3-32-6.3v31.2h-15V330.7c-11-1.8-22-3.4-33-5v38.8h-14V323.8c-27-3.5-54-6.3-82-8.3v49h-26V313.7c-31-1.7-61.7-2.5-92.5-2.6s-60.5.9-92.5,2.6v50.8h-27v-49c-25,2-54,4.8-82,8.3v40.7h-13V325.7c-12,1.5-22,3.2-34,5v33.8h-14V333.2c-12,2-21,4.1-33,6.3v25h-14V342.7c-4,.7-6.1,1.2-9.1,1.9-.7.2-2.4.4-2.8.5.1-.1,0-.2.1-.3s6.8-10.8,8.4-13.3c2.5-.5,67.8-13.2,103.4-18,.5-.1,1-.1,1.5-.2,1.1-.2,2.1-.3,3.2-.4.5-.1,1-.1,1.5-.2,6.8-.9,13.7-1.7,20.6-2.4.5-.1,1-.1,1.5-.2,1-.1,2.1-.3,3.2-.4.5-.1,1-.1,1.5-.2,6.7-.7,13.4-1.4,20.2-2,.5,0,1-.1,1.5-.1l3.1-.3c.5,0,1-.1,1.5-.1,6.6-.6,13.3-1.2,20-1.7.5,0,1-.1,1.5-.1,1-.1,2-.1,3-.2.5,0,1-.1,1.5-.1,3.6-.3,7.2-.5,10.8-.7a2.2,2.2,0,0,0,.8-.1c3.6-.3,7.2-.5,10.9-.7h.8l10.9-.6h.2c1.4-.1,2.9-.2,4.3-.2h.2c7-.4,14.1-.7,21.2-.9h.2c1.4-.1,2.9-.1,4.4-.1h.2c7.1-.3,14.3-.5,21.5-.6.1,0,.1.4.2.4,1.4-.1,2.9.3,4.4.3h.2c7.2,0,14.4-1,21.7-1h.2c1.5,0,3-.1,4.5,0h15a19.27,19.27,0,0,1,2.4.1c6.5,0,13,0,19.5.2h4.6a19.27,19.27,0,0,1,2.4.1c6.5.1,12.9.3,19.3.5.8,0,1.6.1,2.4.1a14.77,14.77,0,0,1,2.1.1c.8,0,1.6.1,2.4.1,6.4.2,12.7.5,19,.8.8,0,1.6.1,2.4.1a14.77,14.77,0,0,1,2.1.1c.8,0,1.6.1,2.4.1,3.1.1,6.2.3,9.2.5.6,0,1.2.1,1.9.1l9.9.6c.6,0,1.3.1,1.9.1,3.4.2,6.9.4,10.3.7.4,0,.9.1,1.3.1,1.1.1,2.1.2,3.2.2.4,0,.9.1,1.3.1,6.7.5,13.5,1.1,20.1,1.7.5,0,.9.1,1.4.1l3.2.3c.5.1,1,.1,1.4.2,6.8.6,13.6,1.3,20.3,2,.4,0,.9.1,1.3.1l3.3.3c.5.1.9.1,1.4.2,6.9.7,13.9,1.6,20.7,2.4.5.1.9.1,1.4.2,1.1.1,2.2.3,3.3.4.5.1,1,.1,1.5.2,35.8,4.7,71.4,10.8,103.8,17.9,1.6,2.5,8.7,13.8,8.7,13.8C650.1,345.2,650.1,345.2,650.1,345.3Z" style="fill:#fff"/><path d="M420.8,140.2a48.37,48.37,0,1,1,40-55.5A48.48,48.48,0,0,1,420.8,140.2Z" style="fill:#fff"/><g style="clip-path:url(#clip-path)"><rect x="361.2" y="29.5" width="19" height="18" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="9.3" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="9" style="fill:#ffb200"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="8.8" style="fill:#ffb300"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="8.5" style="fill:#ffb500"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="8.3" style="fill:#ffb600"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="8" style="fill:#ffb800"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="7.8" style="fill:#ffb900"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="7.6" style="fill:#fb0"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="7.3" style="fill:#ffbc00"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="7.1" style="fill:#ffbe00"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="6.8" style="fill:#ffbf00"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="6.6" style="fill:#ffc000"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="6.3" style="fill:#ffc200"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="6.1" style="fill:#ffc300"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="5.8" style="fill:#ffc400"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="5.6" style="fill:#ffc600"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="5.4" style="fill:#ffc700"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="5.1" style="fill:#ffc800"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="4.9" style="fill:#ffc900"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="4.6" style="fill:#ffca00"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="4.4" style="fill:#ffcb00"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="4.1" style="fill:#fc0"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="3.9" style="fill:#ffcd00"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="3.7" style="fill:#ffce00"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="3.4" style="fill:#ffcf00"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="3.2" style="fill:#ffd000"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="2.9" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="2.7" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="2.4" style="fill:#ffd200"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="2.2" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="1.9" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="1.7" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="1.5" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="1.2" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="1" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="0.7" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="0.5" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path)"><circle cx="370.4" cy="39.6" r="0.2" style="fill:#ffd600"/></g><path d="M381.8,45.5,380,46.8a62.55,62.55,0,0,0-5,4l-1.6,1.5L353.8,19.7Z" style="fill:#ffc400"/><g style="clip-path:url(#clip-path-40)"><rect x="401.2" y="11.5" width="8" height="26" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="8.6" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="8.3" style="fill:#ffb200"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="8.1" style="fill:#ffb300"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="7.9" style="fill:#ffb500"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="7.7" style="fill:#ffb600"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="7.4" style="fill:#ffb800"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="7.2" style="fill:#ffb900"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="7" style="fill:#fb0"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="6.8" style="fill:#ffbc00"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="6.5" style="fill:#ffbe00"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="6.3" style="fill:#ffbf00"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="6.1" style="fill:#ffc000"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="5.9" style="fill:#ffc200"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="5.6" style="fill:#ffc300"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="5.4" style="fill:#ffc400"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="5.2" style="fill:#ffc600"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="5" style="fill:#ffc700"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="4.7" style="fill:#ffc800"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="4.5" style="fill:#ffc900"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="4.3" style="fill:#ffca00"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="4.1" style="fill:#ffcb00"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="3.8" style="fill:#fc0"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="3.6" style="fill:#ffcd00"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="3.4" style="fill:#ffce00"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="3.2" style="fill:#ffcf00"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="2.9" style="fill:#ffd000"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="2.7" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="2.5" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="2.3" style="fill:#ffd200"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="2" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="1.8" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="1.6" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="1.4" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="1.1" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="0.9" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="0.7" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="0.5" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-40)"><circle cx="403.6" cy="24.1" r="0.2" style="fill:#ffd600"/></g><path d="M409.5,36.2l-2.2.2c-1.1.1-2.1.3-3.2.4s-2.1.4-3.2.6l-2.1.5L398.2,0Z" style="fill:#ffc400"/><g style="clip-path:url(#clip-path-79)"><rect x="430.2" y="15.5" width="11" height="26" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="8.9" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="8.7" style="fill:#ffb200"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="8.5" style="fill:#ffb300"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="8.2" style="fill:#ffb500"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="8" style="fill:#ffb600"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="7.8" style="fill:#ffb800"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="7.5" style="fill:#ffb900"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="7.3" style="fill:#fb0"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="7.1" style="fill:#ffbc00"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="6.8" style="fill:#ffbe00"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="6.6" style="fill:#ffbf00"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="6.3" style="fill:#ffc000"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="6.1" style="fill:#ffc200"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="5.9" style="fill:#ffc300"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="5.6" style="fill:#ffc400"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="5.4" style="fill:#ffc600"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="5.2" style="fill:#ffc700"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="4.9" style="fill:#ffc800"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="4.7" style="fill:#ffc900"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="4.5" style="fill:#ffca00"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="4.2" style="fill:#ffcb00"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="4" style="fill:#fc0"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="3.8" style="fill:#ffcd00"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="3.5" style="fill:#ffce00"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="3.3" style="fill:#ffcf00"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="3.1" style="fill:#ffd000"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="2.8" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="2.6" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="2.4" style="fill:#ffd200"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="2.1" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="1.9" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="1.6" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="1.4" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="1.2" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="0.9" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="0.7" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="0.5" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-79)"><circle cx="436.3" cy="28.1" r="0.2" style="fill:#ffd600"/></g><path d="M446.4,4.9,438.1,42l-2-.9a53.32,53.32,0,0,0-6-2.3l-2.1-.7Z" style="fill:#ffc400"/><g style="clip-path:url(#clip-path-118)"><rect x="468.2" y="109.5" width="20" height="11" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="8.9" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="8.7" style="fill:#ffb200"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="8.5" style="fill:#ffb300"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="8.2" style="fill:#ffb500"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="8" style="fill:#ffb600"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="7.8" style="fill:#ffb800"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="7.5" style="fill:#ffb900"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="7.3" style="fill:#fb0"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="7" style="fill:#ffbc00"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="6.8" style="fill:#ffbe00"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="6.6" style="fill:#ffbf00"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="6.3" style="fill:#ffc000"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="6.1" style="fill:#ffc200"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="5.9" style="fill:#ffc300"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="5.6" style="fill:#ffc400"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="5.4" style="fill:#ffc600"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="5.2" style="fill:#ffc700"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="4.9" style="fill:#ffc800"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="4.7" style="fill:#ffc900"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="4.5" style="fill:#ffca00"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="4.2" style="fill:#ffcb00"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="4" style="fill:#fc0"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="3.8" style="fill:#ffcd00"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="3.5" style="fill:#ffce00"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="3.3" style="fill:#ffcf00"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="3.1" style="fill:#ffd000"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="2.8" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="2.6" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="2.3" style="fill:#ffd200"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="2.1" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="1.9" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="1.6" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="1.4" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="1.2" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="0.9" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="0.7" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="0.5" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-118)"><circle cx="477.5" cy="115.6" r="0.2" style="fill:#ffd600"/></g><path d="M500.7,125.8l-37.1-8.3.9-2a61.89,61.89,0,0,0,2.3-6l.7-2.1Z" style="fill:#ffc400"/><g style="clip-path:url(#clip-path-157)"><rect x="456.2" y="41.5" width="21" height="17" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="9.3" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="9" style="fill:#ffb200"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="8.8" style="fill:#ffb300"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="8.5" style="fill:#ffb500"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="8.3" style="fill:#ffb600"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="8" style="fill:#ffb800"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="7.8" style="fill:#ffb900"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="7.6" style="fill:#fb0"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="7.3" style="fill:#ffbc00"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="7.1" style="fill:#ffbe00"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="6.8" style="fill:#ffbf00"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="6.6" style="fill:#ffc000"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="6.3" style="fill:#ffc200"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="6.1" style="fill:#ffc300"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="5.8" style="fill:#ffc400"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="5.6" style="fill:#ffc600"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="5.4" style="fill:#ffc700"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="5.1" style="fill:#ffc800"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="4.9" style="fill:#ffc900"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="4.6" style="fill:#ffca00"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="4.4" style="fill:#ffcb00"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="4.1" style="fill:#fc0"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="3.9" style="fill:#ffcd00"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="3.7" style="fill:#ffce00"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="3.4" style="fill:#ffcf00"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="3.2" style="fill:#ffd000"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="2.9" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="2.7" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="2.4" style="fill:#ffd200"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="2.2" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="1.9" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="1.7" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="1.5" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="1.2" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="1" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="0.7" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="0.5" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-157)"><circle cx="465.9" cy="49.8" r="0.2" style="fill:#ffd600"/></g><path d="M485.7,33.2,460,61.2l-1.3-1.8a62.55,62.55,0,0,0-4-5l-1.5-1.7Z" style="fill:#ffc400"/><g style="clip-path:url(#clip-path-196)"><rect x="471.2" y="80.5" width="21" height="8" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="8.6" style="fill:#ffb000"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="8.3" style="fill:#ffb200"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="8.1" style="fill:#ffb300"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="7.9" style="fill:#ffb500"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="7.7" style="fill:#ffb600"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="7.4" style="fill:#ffb800"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="7.2" style="fill:#ffb900"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="7" style="fill:#fb0"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="6.8" style="fill:#ffbc00"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="6.5" style="fill:#ffbe00"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="6.3" style="fill:#ffbf00"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="6.1" style="fill:#ffc000"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="5.9" style="fill:#ffc200"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="5.6" style="fill:#ffc300"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="5.4" style="fill:#ffc400"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="5.2" style="fill:#ffc600"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="5" style="fill:#ffc700"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="4.7" style="fill:#ffc800"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="4.5" style="fill:#ffc900"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="4.3" style="fill:#ffca00"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="4.1" style="fill:#ffcb00"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="3.8" style="fill:#fc0"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="3.6" style="fill:#ffcd00"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="3.4" style="fill:#ffce00"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="3.2" style="fill:#ffcf00"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="2.9" style="fill:#ffd000"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="2.7" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="2.5" style="fill:#ffd100"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="2.3" style="fill:#ffd200"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="2" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="1.8" style="fill:#ffd300"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="1.6" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="1.4" style="fill:#ffd400"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="1.1" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="0.9" style="fill:#ffd500"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="0.7" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="0.5" style="fill:#ffd600"/></g><g style="clip-path:url(#clip-path-196)"><circle cx="481.4" cy="83" r="0.2" style="fill:#ffd600"/></g><path d="M505.6,77.5,469.4,88.9l-.2-2.2c-.1-1.1-.3-2.1-.4-3.2s-.4-2.1-.6-3.2l-.5-2.1Z" style="fill:#ffc400"/><path d="M420.8,140.2a48.37,48.37,0,1,1,40-55.5A48.48,48.48,0,0,1,420.8,140.2Z" style="fill:url(#radial-gradient)"/></g></g></svg></div><div id="sbs-widget__status" style="font-size:20px; font-family: \'Roboto, Arial, sans-serif; font-weight: 400;"><p style="font-size:1em; font-family: \'Roboto\', Arial, sans-serif;">The Sunshine Skyway Bridge is currently<br/><span style="text-transform:uppercase; font-size:1.5em; line-height:1.5em; color:' + json.color + ';">' + json.status + '<span></p><p style="text-decoration:none; text-decoration-style:none; font-size:0.75em; font-family: \'Roboto\', Arial, sans-serif;">Visit <span style="text-decoration:underline;">SkywayBridgeStatus.com</span> to learn more.</p></div></div></a>'
    document.getElementById("sbs-widget").innerHTML = widgetHTML;
}


