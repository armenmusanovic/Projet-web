let lista = JSON.parse(localStorage.getItem("lista")) || [];

const posmatrac = new IntersectionObserver(function (zapisi) {
  zapisi.forEach(function (zapis) {
    if (zapis.isIntersecting) {
      zapis.target.classList.add("vidljivo");
      posmatrac.unobserve(zapis.target);
    }
  });
}, { threshold: 0.15 });

function pokreniReveal() {
  document.querySelectorAll(".reveal").forEach(function (el) {
    posmatrac.observe(el);
  });
}

function spremi() {
  localStorage.setItem("lista", JSON.stringify(lista));
  prikaziListu();
}

function prikaziListu() {
  const prikaz = document.getElementById("lista");
  if (!prikaz) return;
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

function pokreniZahtjev() {
  const formaStavka = document.getElementById("forma-stavka");
  const formaUpit = document.getElementById("forma-upit");
  if (!formaStavka) return;

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

function pokreniAuth() {
  ["login-form", "register-form"].forEach(function (id) {
    const forma = document.getElementById(id);
    if (!forma) return;
    forma.addEventListener("submit", function (e) {
      e.preventDefault();
      alert("Povezivanje sa serverom (JWT prijava) dodajemo u kasnijim milestoneima.");
    });
  });
}

document.addEventListener("viewloaded", function () {
  pokreniReveal();
  pokreniZahtjev();
  pokreniAuth();
});