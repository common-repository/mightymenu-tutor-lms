// Function to toggle the dark mode for the app bar and save the user's preference in local storage.
function toggleAppBarDarkMode() {
  const darkLink = document.querySelector(".button-toggle-appbar");

  if (darkLink) {
    const isDarkTheme = darkLink.classList.toggle("dark-theme");
    localStorage.setItem("color-mode", isDarkTheme ? "dark" : "light");
  }
}

// Array of tab menu and content selectors
const tabs = [
  { menu: ".sidebar-friends-menu", content: ".sidebar-friends-content" },
  { menu: ".sidebar-course-menu", content: ".sidebar-course-content" },
  { menu: ".sidebar-notification-menu", content: ".sidebar-notification-content" }
];

// Function to toggle tabs on click
function toggleTabs(menuSelector, contentSelector) {
  const menu = document.querySelector(menuSelector);
  const content = document.querySelector(contentSelector);

  if (menu && content) {
    menu.addEventListener("click", () => {
      tabs.forEach(({ content: c }) => {
        const tabContent = document.querySelector(c);
        if (c === contentSelector) {
          if (tabContent) {
            tabContent.classList.toggle("active");
            tabContent.style.display = tabContent.classList.contains("active") ? "block" : "none";
          }
        } else if (tabContent) {
          tabContent.classList.remove("active");
          tabContent.style.display = "none";
        }
      });
    });
  }
}

// Call the toggleTabs function for each tab
tabs.forEach(({ menu, content }) => toggleTabs(menu, content));

// Event listener for app bar dark mode toggle button
const appBarDarkModeBtn = document.querySelector(".appbar__dark");
if (appBarDarkModeBtn) {
  appBarDarkModeBtn.addEventListener("click", toggleAppBarDarkMode);
}

const darkLink = document.querySelector(".button-toggle-appbar");
const colorMode = localStorage.getItem('color-mode');

if(darkLink){
  darkLink.classList.toggle('dark-theme', colorMode === 'dark');
}
