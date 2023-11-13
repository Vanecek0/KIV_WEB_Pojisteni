async function searchIco(id) {
  var icoInput = $('#' + id).val();

  var url = 'http://pojisteni.localhost.com/ares?ico=' + icoInput;

  const response = await fetch(url, {
    method: "GET",
  });

  var parser = new DOMParser();
  const responseData = await response.text();
  var xmlDoc = parser.parseFromString(responseData, "text/xml");

  var ares_response = xmlDoc.lastChild.childNodes[1];
  var ares_v = ares_response.childNodes[1];

  if (ares_v.nodeName != "dtt:Help") {
    var aresinfo = ares_v.childNodes[1];

    var aresInfoArr = Array.from(aresinfo.childNodes).filter(function (node) {
      return node.nodeType === 1;
    });

    var ico = aresInfoArr[0].textContent;
    var pf = aresInfoArr[1].textContent;
    var name = aresInfoArr[2].textContent;
    var address = aresInfoArr[3].textContent;

    document.getElementById('result').innerHTML = address;
  }
}
