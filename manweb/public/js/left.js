document.getElementById("sidebar-submenu-expanded-dashboard").style.display = "none";
document.getElementById("sidebar-submenu-expanded-home").style.display = "none";
document.getElementById("sidebar-submenu-expanded-marcas").style.display = "none";
document.getElementById("sidebar-submenu-expanded-recursos").style.display = "none";
document.getElementById("sidebar-submenu-expanded-patrimonio").style.display = "none";

function FunExpandMenuDashboard() {

    switch (
    document.getElementById("sidebar-submenu-expanded-dashboard").style.display
    ) {
        case "none":
            document.getElementById("sidebar-submenu-expanded-dashboard").style.display = "block";

            break;
        case "block":
            document.getElementById("sidebar-submenu-expanded-dashboard").style.display = "none";
            break;
    }
}
function FunExpandMenuHome() {
    switch (
    document.getElementById("sidebar-submenu-expanded-home").style.display
    ) {
        case "none":
            document.getElementById(
                "sidebar-submenu-expanded-home"
            ).style.display = "block";
            document.getElementById(
                "sidebar-submenu-expanded-marcas"
            ).style.display = "none";
            document.getElementById(
                "sidebar-submenu-expanded-recursos"
            ).style.display = "none";
            document.getElementById(
                "sidebar-submenu-expanded-patrimonio"
            ).style.display = "none";
            break;
        case "block":
            document.getElementById(
                "sidebar-submenu-expanded-home"
            ).style.display = "none";
            break;
    }
}
function FunExpandMenuMarcas() {
    switch (
    document.getElementById("sidebar-submenu-expanded-marcas").style.display
    ) {
        case "none":
            document.getElementById(
                "sidebar-submenu-expanded-marcas"
            ).style.display = "block";
            document.getElementById(
                "sidebar-submenu-expanded-home"
            ).style.display = "none";

            document.getElementById(
                "sidebar-submenu-expanded-recursos"
            ).style.display = "none";
            document.getElementById(
                "sidebar-submenu-expanded-patrimonio"
            ).style.display = "none";
            break;
        case "block":
            document.getElementById(
                "sidebar-submenu-expanded-marcas"
            ).style.display = "none";
            break;
    }
}
function FunExpandMenuRecursos() {
    switch (
    document.getElementById("sidebar-submenu-expanded-recursos").style
        .display
    ) {
        case "none":
            document.getElementById(
                "sidebar-submenu-expanded-recursos"
            ).style.display = "block";
            document.getElementById(
                "sidebar-submenu-expanded-home"
            ).style.display = "none";
            document.getElementById(
                "sidebar-submenu-expanded-marcas"
            ).style.display = "none";

            document.getElementById(
                "sidebar-submenu-expanded-patrimonio"
            ).style.display = "none";
            break;
        case "block":
            document.getElementById(
                "sidebar-submenu-expanded-recursos"
            ).style.display = "none";
            break;
    }
}
function FunExpandMenuPeatrimonio() {
    switch (
    document.getElementById("sidebar-submenu-expanded-patrimonio").style
        .display
    ) {
        case "none":
            document.getElementById(
                "sidebar-submenu-expanded-patrimonio"
            ).style.display = "block";
            document.getElementById(
                "sidebar-submenu-expanded-home"
            ).style.display = "none";
            document.getElementById(
                "sidebar-submenu-expanded-marcas"
            ).style.display = "none";
            document.getElementById(
                "sidebar-submenu-expanded-recursos"
            ).style.display = "none";

            break;
        case "block":
            document.getElementById(
                "sidebar-submenu-expanded-patrimonio"
            ).style.display = "none";
            break;
    }
}
