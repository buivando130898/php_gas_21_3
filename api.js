const fetch = require('node-fetch');
function gas() {
const endpoint = 'https://api.etherscan.io/api?module=gastracker&action=gasoracle&apikey=A3MXYC2RACK6CAKUN1J1GDFIF78F9QYKKI';

fetch(endpoint)
     .then((response) => response.json())
     .then((data) => {
          console.log(data.result.SafeGasPrice);
          console.log(data.result.ProposeGasPrice);
          console.log(data.result.FastGasPrice);
          console.log("------------")
     
     });
}

function test(){
     console.log("test")
}

setInterval(
     () => {
     gas();
     },
     10000
   );
   
