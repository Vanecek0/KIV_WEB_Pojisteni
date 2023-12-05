async function searchIco(element) {
  var icoInput = $(element).val();

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


    var name = (aresInfoArr[2].textContent).split(' ');
    var street = aresInfoArr[3].textContent;



    $('[name="firstname"]').val(name[0]);
    $('[name="lastname"]').val(name.slice(1).join(' '));
    $('[name="street"]').val(street);

  }
}
