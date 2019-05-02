
var container = document.getElementById('all-posts');
var load_more = document.getElementById('load-more');

function showSpinner() {
  var spinner = document.getElementById("spinner");
  spinner.style.display = 'block';
}

function hideSpinner() {
  var spinner = document.getElementById("spinner");
  spinner.style.display = 'none';
}

function showLoadMore() {
  load_more.style.display = 'inline';
}

function hideLoadMore() {
  load_more.style.display = 'none';
}

function appendToDiv(div, new_html) {
  // Put the new HTML into a temp div
  // This causes browser to parse it as elements.
  var temp = document.createElement('div');
  temp.innerHTML = new_html;

  // Then we can find and work with those elements.
  // Use firstElementChild b/c of how DOM treats whitespace.
  var class_name = temp.firstElementChild.className;
  var items = temp.getElementsByClassName(class_name);

  var len = items.length;
  for(i=0; i < len; i++) {
    div.appendChild(items[0]);
  }
}

function setCurrentPage(post) {
  console.log('Incrementing post to: ' + post);
  load_more.setAttribute('data-page', post);
}

function loadMore() {

  showSpinner();
  hideLoadMore();

  var post = parseInt(load_more.getAttribute('data-page'));
  var next_post = post + 1;

  var xhr = new XMLHttpRequest();
  xhr.open('GET', '../index.php?post=' + next_post, true);
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.onreadystatechange = function () {
    if(xhr.readyState == 4 && xhr.status == 200) {
      var result = xhr.responseText;
      console.log('Result: ' + result);

      hideSpinner();
      setCurrentPage(next_post);
      // append results to end of blog posts
      appendToDiv(container, result);
      showLoadMore();

    }
  };
  xhr.send();
}

load_more.addEventListener("click", loadMore);

// Load even the first page with Ajax
loadMore();

