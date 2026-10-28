
const elementi = document.querySelectorAll(".reveal");

const posmatrac = new IntersectionObserver(function (zapisi) {
  zapisi.forEach(function (zapis) {
    if (zapis.isIntersecting) {
      zapis.target.classList.add("vidljivo");
      posmatrac.unobserve(zapis.target);
    }
  });
}, { threshold: 0.15 });

elementi.forEach(function (el) { posmatrac.observe(el); });


let lista = JSON.parse(localStorage.getItem("lista")) || [];

const formaStavka = document.getElementById("forma-stavka");
const formaUpit = document.getElementById("forma-upit");
const prikaz = document.getElementById("lista");

function spremi() {
  localStorage.setItem("lista", JSON.stringify(lista));
  prikaziListu();
}

function prikaziListu() {
  prikaz.innerHTML = "";

  if (lista.length === 0) {
    prikaz.innerHTML = "<li>Lista je prazna.</li>";
    return;
  }

  lista.forEach(function (stavka, i) {
    const li = document.createElement("li");
    li.textContent =
      stavka.proizvod + ", " + stavka.kamen + ", " +
      stavka.duzina + "x" + stavka.sirina + "x" + stavka.visina + " cm" +
      (stavka.tekst ? ', tekst: "' + stavka.tekst + '"' : "");

    const ukloni = document.createElement("button");
    ukloni.textContent = "Ukloni";
    ukloni.addEventListener("click", function () {
      lista.splice(i, 1);
      spremi();
    });

    li.appendChild(ukloni);
    prikaz.appendChild(li);
  });
}

if (formaStavka) {
  formaStavka.addEventListener("submit", function (e) {
    e.preventDefault();

    lista.push({
      proizvod: document.getElementById("proizvod").value,
      kamen: document.getElementById("kamen").value,
      duzina: document.getElementById("duzina").value,
      sirina: document.getElementById("sirina").value,
      visina: document.getElementById("visina").value,
      tekst: document.getElementById("tekst").value.trim()
    });

    spremi();
    formaStavka.reset();
  });

  formaUpit.addEventListener("submit", function (e) {
    e.preventDefault();

    if (lista.length === 0) {
      alert("Dodajte barem jednu stavku u listu.");
      return;
    }

    alert("Upit je spreman. Slanje na server (AJAX + PHP) dodajemo kasnije.");
  });

  prikaziListu();
}