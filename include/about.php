<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
// hide all error
error_reporting(0);
if(!isset($_SESSION["mikhmon"])){
  header("Location:../admin.php?id=login");
}else{
}
?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3><i class="fa fa-info-circle"></i> About</h3>
      </div>
      <div class="card-body">
        <h3>AERO HOTSPOT SYSTEM V3.4</h3>
<p>
  Aplikasi ini digunakan untuk managemen hotspot CV. Mitra Tech Aero.
</p>
<p>
  <ul>
    <li>
      Author : Hardi Agunadi / HP WA 085-743-363-803
    </li>
    <li>
      Licence : <a href="https://github.com/laksa19/mikhmonv2/blob/master/LICENSE">GPLv2</a>
    </li>
    <li>
      API Class : <a href="https://github.com/BenMenking/routeros-api">routeros-api</a>
    </li>
    <!--li>
      Website : <a href="https://laksa19.github.io">laksa19.github.io</a>
    </li-->
    <!--li>
      Facebook : <a href="https://fb.com/laksamadi">fb.com/laksamadi</a>
    </li-->
  </ul>
</p>
<!--p>
  Terima kasih untuk semua yang telah mendukung pengembangan MIKHMON.
</p-->
<div>
    <i>Copyright &copy; <i> 2018 CV. Mitra Tech Aero</i></i>
</div>
</div>
</div>
</div>
</div>
