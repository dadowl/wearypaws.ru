var modal1 = document.getElementById('myModal1');
var modal2 = document.getElementById('myModal2');
var modal3 = document.getElementById('myModal3');
var modal4 = document.getElementById('myModal4');
var modal5 = document.getElementById('myModal5');
var modal6 = document.getElementById('myModal6');

function showModal(a){
  if (a == 1){ modal1.style.display = 'block'; }
  if (a == 2){ modal2.style.display = 'block'; }
  if (a == 3){ modal3.style.display = 'block'; }
  if (a == 4){ modal4.style.display = 'block'; }
  if (a == 5){ modal5.style.display = 'block'; }
  if (a == 6){ modal6.style.display = 'block'; }
}

window.onclick = function(event) {
  if (event.target == modal1) { modal1.style.display = "none"; }
  if (event.target == modal2) { modal2.style.display = "none"; }
  if (event.target == modal3) { modal3.style.display = "none"; }
  if (event.target == modal4) { modal4.style.display = "none"; }
  if (event.target == modal5) { modal5.style.display = "none"; }
  if (event.target == modal6) { modal6.style.display = "none"; }
}

function closeModal(b){
  if (b == 1){ modal1.style.display = 'none'; }
  if (b == 2){ modal2.style.display = 'none'; }
  if (b == 3){ modal3.style.display = 'none'; }
  if (b == 4){ modal4.style.display = 'none'; }
  if (b == 5){ modal5.style.display = 'none'; }
  if (b == 6){ modal6.style.display = 'none'; }
}