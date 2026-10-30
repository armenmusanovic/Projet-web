const routes = {
  home: "views/home.html",
  radovi: "views/radovi.html",
  kamen: "views/kamen.html",
  about: "views/about.html",
  zahtjev: "views/zahtjev.html",
  login: "views/login.html",
  register: "views/register.html"
};

const cache = {}; // svaki view se učita samo jednom

async function loadView() {
  const app = document.getElementById("app");
  let name = location.hash.replace("#", "") || "home";
  if (!routes[name]) name = "home";

  if (!cache[name]) {
    try {
      const response = await fetch(routes[name]);
      if (!response.ok) throw new Error("Not found");
      cache[name] = await response.text();
    } catch (error) {
      app.innerHTML = "<p>Stranica se ne može učitati.</p>";
      return;
    }
  }

  app.innerHTML = cache[name];
  window.scrollTo(0, 0);

  document.querySelectorAll("nav a").forEach(function (link) {
    link.classList.toggle("aktivna", link.dataset.route === name);
  });

  document.dispatchEvent(new Event("viewloaded"));
}

window.addEventListener("hashchange", loadView);
window.addEventListener("DOMContentLoaded", loadView);