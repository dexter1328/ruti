const searchBtn2 = document.querySelector('#search-btn2');
const searchResults2 = document.querySelector('.first_main_div2');
const searchInput2 = document.querySelector('.search-container2 input[type=text]');

searchResults2.style.display = 'none';
searchBtn2.addEventListener('click', () => {
  if (searchResults2.style.display === 'block') {
    searchResults2.style.display = 'none';
  } else {
    searchResults2.style.display = 'block';
  }
});
document.addEventListener('click', (event) => {
  const isClickInsideSearchResults = searchResults2.contains(event.target);
  const isClickInsideSearchContainer = event.target.closest('.search-container2');

  if (!isClickInsideSearchResults && !isClickInsideSearchContainer) {
    searchResults2.style.display = 'none';
  }
});

searchInput2.addEventListener('click', (event) => {
  event.stopPropagation();
});