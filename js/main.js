const navItens = document.querySelector('.nav_itens');
const openNavBtn = document.querySelector('#open_nav-btn');
const closeNavBtn = document.querySelector('#close_nav-btn');

// opens nav dropdown (abrir menu de navegacao de tres barras)
const openNav = () => {
   navItens.style.display = 'flex';
   openNavBtn.style.display = 'none';
   closeNavBtn.style.display = 'inline-block';
}


// close nav dropdown (fechar menu de navegacao de tres barras)
const closeNav = () => {
   navItens.style.display = 'none';
   openNavBtn.style.display = 'inline-block';
   closeNavBtn.style.display = 'none';
}


openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener('click', closeNav);


const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show_sidebar-btn')
;
const hideSidebarBtn = document.querySelector('#hide_sidebar-btn')
;



// show sidebar on small devices (mostrando o por baixo no canto esquerdo)
const showSidebar =  ()  => {
   sidebar.style.left = '0';
   showSidebarBtn.style.display = 'none';
   hideSidebarBtn.style.display = 'inline-block';
}


// hides sidebar on small devices (fechar o por baix no canto esquerdo)
const hideSidebar =  ()  => {
   sidebar.style.left = '-100%';
   showSidebarBtn.style.display = 'inline-block';
   hideSidebarBtn.style.display = 'none';
}

showSidebarBtn.addEventListener('click', showSidebar);
hideSidebarBtn.addEventListener('click', hideSidebar);


