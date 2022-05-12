function mmLoadMenus(opcaomenu) {

    if (window.mm_menu_0314111426_0)
        return;

    if (opcaomenu == 2) {

        window.mm_menu_0517152555_0 = new Menu("root", 200, 22, "Arial, Helvetica, sans-serif", 16, "#000000", "#ffffff", "#d4d0c8", "#000084", "left", "middle", 3, 0, 1000, -5, 7, true, true, true, 0, false, true);
        mm_menu_0517152555_0.addMenuItem("Web Service", "window.open('wstoy.php?flagmenu='+2, '_self');");
        mm_menu_0517152555_0.addMenuItem("Encerrar Sessao", "window.open('login_encerra.php', '_self');");
        mm_menu_0517152555_0.hideOnMouseOut = true;
        mm_menu_0517152555_0.childMenuIcon = "images/arrows.gif";
        mm_menu_0517152555_0.menuBorder = 1;
        mm_menu_0517152555_0.menuLiteBgColor = '#ffffff';
        mm_menu_0517152555_0.menuBorderBgColor = '#555555';
        mm_menu_0517152555_0.bgColor = '#555555';

        window.mm_menu_0517152554_0 = new Menu("root", 200, 22, "Arial, Helvetica, sans-serif", 16, "#000000", "#ffffff", "#d4d0c8", "#000084", "left", "middle", 3, 0, 1000, -5, 7, true, true, true, 0, false, true);
        mm_menu_0517152554_0.addMenuItem("Usuários", "window.open('cadusuarios.php', '_self');");   
        mm_menu_0517152554_0.addMenuItem("Alterar Senha (ADM)", "window.open('ususenha.php', '_self');");
        mm_menu_0517152554_0.addMenuItem("Alterar Senha", "window.open('ususenhau.php', '_self');");
        mm_menu_0517152554_0.hideOnMouseOut = true;
        mm_menu_0517152554_0.childMenuIcon = "images/arrows.gif";
        mm_menu_0517152554_0.menuBorder = 1;
        mm_menu_0517152554_0.menuLiteBgColor = '#ffffff';
        mm_menu_0517152554_0.menuBorderBgColor = '#555555';
        mm_menu_0517152554_0.bgColor = '#555555';

        window.mm_menu_0517152553_0 = new Menu("root", 200, 22, "Arial, Helvetica, sans-serif", 16, "#000000", "#ffffff", "#d4d0c8", "#000084", "left", "middle", 3, 0, 1000, -5, 7, true, true, true, 0, false, true);

        mm_menu_0517152553_0.addMenuItem("Importação Abrangência", "window.open('importafrete.php', '_self');");     
		mm_menu_0517152553_0.addMenuItem("Importação Pesos", "window.open('importapeso.php', '_self');");  
		mm_menu_0517152553_0.addMenuItem("Importação Preços", "window.open('importapreco.php', '_self');"); 
		mm_menu_0517152553_0.addMenuItem("Imp. Retira Correio xls", "window.open('importaretira.php', '_self');");
		mm_menu_0517152553_0.addMenuItem("Imp. Retira Correio xlsx", "window.open('importaretiraxlsx.php', '_self');");
		mm_menu_0517152553_0.addMenuItem("Exclusão de Dados", "window.open('exclusaotransportadora.php', '_self');");  	
        mm_menu_0517152553_0.hideOnMouseOut = true;
        mm_menu_0517152553_0.childMenuIcon = "images/arrows.gif";
        mm_menu_0517152553_0.menuBorder = 1;
        mm_menu_0517152553_0.menuLiteBgColor = '#ffffff';
        mm_menu_0517152553_0.menuBorderBgColor = '#555555';
        mm_menu_0517152553_0.bgColor = '#555555';

        window.mm_menu_0517152552_0 = new Menu("root", 173, 22, "Arial, Helvetica, sans-serif", 16, "#000000", "#ffffff", "#d4d0c8", "#000084", "left", "middle", 3, 0, 1000, -5, 7, true, true, true, 0, false, true);
        mm_menu_0517152552_0.addMenuItem("Produtos Excel", "window.open('consultaprodutosexcel.php', '_self');");  
		mm_menu_0517152552_0.addMenuItem("Frete Produtos Excel", "window.open('consultafreteprodutosexcel.php', '_self');"); 
		mm_menu_0517152552_0.addMenuItem("Vtex Excel", "window.open('vtextransportadora.php', '_self');"); 
		mm_menu_0517152552_0.addMenuItem("AnyMarket Excel", "window.open('anymarkettransportadora.php', '_self');"); 
        mm_menu_0517152552_0.hideOnMouseOut = true;
        mm_menu_0517152552_0.childMenuIcon = "images/arrows.gif";
        mm_menu_0517152552_0.menuBorder = 1;
        mm_menu_0517152552_0.menuLiteBgColor = '#ffffff';
        mm_menu_0517152552_0.menuBorderBgColor = '#555555';
        mm_menu_0517152552_0.bgColor = '#555555';

        window.mm_menu_0314111426_0 = new Menu("root", 200, 22, "Arial, Helvetica, sans-serif", 16, "#000000", "#ffffff", "#d4d0c8", "#000084", "left", "middle", 3, 0, 1000, -5, 7, true, true, true, 0, false, true);
        mm_menu_0314111426_0.addMenuItem("Valor Frete", "window.open('consultafrete.php', '_self');");     
		mm_menu_0314111426_0.addMenuItem("Frete Simples", "window.open('consultafretesimples.php', '_self');");   
		mm_menu_0314111426_0.addMenuItem("Frete por Produto", "window.open('consultafreteproduto.php', '_self');");   
        mm_menu_0314111426_0.hideOnMouseOut = true;
        mm_menu_0314111426_0.childMenuIcon = "images/arrows.gif";
        mm_menu_0314111426_0.menuBorder = 1;
        mm_menu_0314111426_0.menuLiteBgColor = '#ffffff';
        mm_menu_0314111426_0.menuBorderBgColor = '#555555';
        mm_menu_0314111426_0.bgColor = '#555555';

        window.mm_menu_0108112640_0 = new Menu("root", 173, 22, "Arial, Helvetica, sans-serif", 16, "#000000", "#ffffff", "#d4d0c8", "#000084", "left", "middle", 3, 0, 1000, -5, 7, true, true, true, 0, false, true);
		mm_menu_0108112640_0.addMenuItem("Em Desenvolvimento", "window.open('wstoy.php?flagmenu='+2, '_self');");
        mm_menu_0108112640_0.hideOnMouseOut = true;
        mm_menu_0108112640_0.childMenuIcon = "images/arrows.gif";
        mm_menu_0108112640_0.menuBorder = 1;
        mm_menu_0108112640_0.menuLiteBgColor = '#ffffff';
        mm_menu_0108112640_0.menuBorderBgColor = '#555555';
        mm_menu_0108112640_0.bgColor = '#555555';

        mm_menu_0108112640_0.writeMenus();
    }


}// mmLoadMenus()
