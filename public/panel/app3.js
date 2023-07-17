const searchBtn = document.querySelector('#search-btn');
const searchResults = document.querySelector('.first_main_div');
const searchInput = document.querySelector('.search-container input[type=text]');

searchResults.style.display = 'block';
searchBtn.addEventListener('click', () => {
  if (searchResults.style.display === 'block') {
    searchResults.style.display = 'none';
  } else {
    searchResults.style.display = 'block';
  }
});
document.addEventListener('click', (event) => {
    const isClickInsideSearchResults = searchResults.contains(event.target);
    const isClickInsideSearchContainer = event.target.closest('.search-container');
  
    if (!isClickInsideSearchResults && !isClickInsideSearchContainer) {
      searchResults.style.display = 'none';
    }
  });
  
  searchInput.addEventListener('click', (event) => {
    event.stopPropagation();
  });