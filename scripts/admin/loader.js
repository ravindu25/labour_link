function closeLoader(){
    const loaderContainer = document.getElementById("loader-container");
    const mainContent = document.getElementById("main-content-container");

    loaderContainer.style.display = 'none';
    mainContent.style.display = 'block';
    console.log('Function executed!');
}