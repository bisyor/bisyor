<?php
/**
 * @var $this yii\web\View
 */
?>


<div class="row">
    <div class="col-md-12">
        <h5 style="margin-left: 1%">
            <b>
                Kategoriyalar sahifasi
            </b>
            <b>
                <a href="/items/categories/index" class="text-primary"> (Sahifa uchun havola) <i
                        class="fa fa-external-link"></i></a>
            </b>
        </h5>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-11">
        <img src="../uploads/statistika/items_category.png" style="width: 90%;">
    </div>

    <div class="col-md-11" style="margin-left: 3%">
        <h5>
            <p> - Kategoriyalar bu saytdagi e'lonlarni guruhlash uchun va har bir kategoriyani o'ziga xos qo'shimcha maydonlari mavjud.
                E'lon qo'shishda shu qo'shimcha maydonlarga mos ma'lumot kiritish kerak. Kategoriyalar orqali qo'shimcha maydonlarni xam to'dirishini foydalanuvchidan talab qilinadi.
                - Har bir kategoriyaning o'zi ham ma'lum bir guruhchalardan iborat.
                Masalan: "Transport" ni misol qilib olsak.
               </p>
            <p> Bu kategoriya o'zi o'z ichiga "yengil moshinalar" , "yuk mashinalari" ...  kabilarni o'z ichiga oladi.</p>
        </h5>
        <div class="col-md-4">
            <h5>
                <p> <b>Shu rasmda bunga yana bir misolni ko'rish mumkin.</b></p>
                <p> Bu yerda <b>Shop</b> bosh kategoriya  , <b>Boks</b> va <b>Hardware</b> uning birinchi bolalari. unda keyingilari xam
                huddi shu ko'rinishda davom etgan.</p>
            </h5>
        </div>
        <div class="col-md-8">
            <img src="../uploads/statistika/category_primer.png" style="width: 60%">
        </div>
        <h4> Yuqoridagi rasmda : </h4>
        <h5>
            <p> <b>1. Tugmalar</b></p>
            <p>  <span class="btn btn-success btn-xs">Добавить <i class="fa fa-plus"></i></span>  - Bu tugma yangi kategoriya qo'shish uchun ishlatiladi.</p>
            <p>  <span class="btn btn-warning btn-xs"> <i class="glyphicon glyphicon-sort"></i> Сортировка</span>  - Bu tugma bosh kategoriyalarni joylashgan tartibini o'zgartitish uchun ishlatiladi uchun ishlatiladi.</p>
        </h5>
        <h5>
            <p> <b>2. Tugmalar</b></p>
            <p> <span class="btn btn-primary btn-xs">  <i class="glyphicon glyphicon-pencil"></i></span> - Bu tugma shu kategoriyani ma'lumotlarini o'zgartirish imkonini beradi.</p>
            <p> <span class="btn btn-warning btn-xs">  <i class="fa fa-cogs"></i></span> - Bu tugma orqali, e'lon kiritishda ma'lum bir kategoriya tanlanganda , shu kategoriyaga
                tegishli qo'shimcha maydonlar talab qilinishi yuqorida aytildi. Kategoriyalarga usha maydonlarni shu yerdan kiritiladi , o'zgartitiladi. </p>
            <p> <span class="btn btn-success btn-xs">  <i class="glyphicon glyphicon-plus"></i></span> - Bu tugma shu kategoriyaga bola kategoriya qo'shish imkoniyatini beradi. </p>
            <p> <span class="btn btn-danger btn-xs">  <i class="glyphicon glyphicon-trash"></i></span> - Bu tugma kategoriyani o'chirish uchun kerak. </p>
        </h5>
        <h5>
            <p> <b>3. Tugmalar</b></p>
            <p>  <span class="glyphicon glyphicon-expand"></span> -Bu tugma shu kategoriyani bolalarini ko'rish imkonini beradi. </p>
        </h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <h5 style="margin-left: 1%">
            <b>
                Yangi kategoriya yaratish , o'zgartirish
            </b>
        </h5>
    </div>
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class=""><a href="#default-tabs-cateroy-1" data-toggle="tab"> forma </a></li>
            <li class=""><a href="#default-tabs-cateroy-2" data-toggle="tab"> forma haqida ma'lumot </a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in" id="default-tabs-cateroy-1">
                <div class="col-md-1 ">
                </div>
                <div class="col-md-11">
                    <img src="../uploads/statistika/items_category_create.png" style="width: 90%;">
                </div>
            </div>
            <div class="tab-pane fade" id="default-tabs-cateroy-2">
                <div class="col-md-12" style="margin-left: 3%">
                    <br>
                    <h5>
                        <p> yangi kategoriya qo'shish va uni o'zgartirish formasi xuddi shu ko'rinishda bo'ladi .</p>
                        <p><b>1.</b> - Yaratmoqchi bo'lgan kategoriyangiz otasini tanlashingiz kerak va
                            unga mos sarlavha tanlashish zarur.</p>
                        <p><b>2.</b> - Bu kategoriyada nima asosan maqsad qilib ochilyotganlifi ,  sotish , sotib olish , ish taklif qilish...</p>
                        <p><b>3.</b> - E'lon qo'shishda, shu kategoriya tanlansa uni narxi qanday tartibda bo'lishi shu yerdan belgilanadi. Narx belgilanadimi yoki yo'qligi. Belgilansa qanday tartibda ekanligi. </p>
                        <p><b>4.</b> - Kim tomonidan belgilanishi</p>
                        <p><b>5.</b> - Manzili haqida ma'lumot</p>
                        <p><b>6.</b> - Kategoriyaga mos rasmlar</p>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

