var cur_ad_container = document.querySelector(".main__container");
var ad_loader = document.getElementById("more_ad_button");

function loadAds(event) {
  let page = parseInt(ad_loader.getAttribute("data-page"));
  page++;

  let max_page = parseInt(ad_loader.getAttribute("data-max-page"));
  let offset = parseInt(ad_loader.getAttribute("offset"));
  let url = "more_ads.php?page=" + page + "&offset=" + offset;
  fetch(url)
    .then((response) => response.text())
    .then((result) => {
      cur_ad_container.insertAdjacentHTML("beforeend", result);
      ad_loader.setAttribute("data-page", page.toString());
      if (page == max_page) {
        ad_loader.remove();
      }
    })
    .catch((error) => console.log(error));
}

ad_loader.onclick = function () {
  loadAds();
};
