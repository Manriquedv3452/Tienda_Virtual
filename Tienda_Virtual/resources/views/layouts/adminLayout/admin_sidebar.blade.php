<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Inicio</a>
  <ul>
    <!--sidebar-inicio
    <li class="active"><a href="{{url('/admin/inicio')}}"><i class="icon icon-home"></i> <span>Inicio</span></a> </li>-->
    <li class="submenu"> <a href="#"><i class="icon icon-th-large"></i> <span>Categoría</span></a>
      <ul>
        <li><a href="{{url('/admin/indexCategoria')}}">Ver Categorías</a></li>
        <li><a href="{{url('/admin/agregarCategoria')}}"> Agregar Categoría</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-list"></i> <span>Productos</span></a>
      <ul>
        <li><a href="{{url('/admin/indexProducto')}}">Ver Productos</a></li>
        <li><a href="{{url('/admin/agregarProducto')}}"> Agregar Producto</a></li>
      </ul>
    </li>
  </ul>
</div>
<!--sidebar-menu-->
