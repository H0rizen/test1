<!DOCTYPE html>
<html xml:lang="fa" lang="fa">
<head>
{headers}
<link media="screen" href="{THEME}/style/styles.css" type="text/css" rel="stylesheet" />
<link media="screen" href="{THEME}/style/engine.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{THEME}/js/libs.js"></script>
</head>
<body>
{AJAX}

<div class="modal">
	<div class="modal-bg"></div>
	<div class="modal-box">
		<div class="modal-title"><div>ورود به سایت</div><span class="modal-close"></span></div>
		<div class="modal-content">تست</div>
	</div>
</div>

<header class="header">
	
	<div class="topbar">
		<div class="wrapper">

			<div class="right">
				امروز: {today}
			</div>

			<div class="left">
				{login}
			</div>

		</div>
	</div>

	<h1>دیتالایف انجین فارسی</h1>
	<h2>سیستم مدیریت محتوای</h2>

</header>

<nav class="navigation">
	<ul>
		<li><a href="/">صفحه نخست</a></li>
		<li class="sub">
			<a href="#">منوی کشویی</a>
			<ul>
				<li><a href="#">منوی اول</a></li>
				<li><a href="#">منوی دوم</a></li>
				<li><a href="#">منوی سوم</a></li>
				<li><a href="#">منوی چهارم</a></li>
				<li><a href="#">منوی پنجم</a></li>
			</ul>
		</li>
		<li><a href="/index.php?do=rules">قوانین سایت</a></li>
		<li><a href="/index.php?">درباره ما</a></li>
		<li><a href="/index.php?do=feedback">تماس با ما</a></li>
	</ul>
</nav>

<div class="wrapper">

	<aside class="sidebar">
		
		<section class="section">
			<form action="" name="searchform" method="post">
				<input type="text" id="story" name="story" placeholder="جستجو در اخبار...">
				<input type="submit" value="Go">
				<input type="hidden" name="do" value="search" />
				<input type="hidden" name="subaction" value="search" />
			</form>
		</section>
		
		<section class="section">
			<header class="section-title"><span>دسته بندی اخبار</span></header>
			{include file="engine/modules/category.php"}
		</section>
		
		<section class="section">
			<header class="section-title"><span>برترین مطالب</span></header>
			<ul>
				{include file="engine/modules/3news.php?mod=topnews&template=topnews&from=0&limit=10"}
			</ul>
		</section>

		<section class="section">
			<header class="section-title"><span>تقویم مطالب</span></header>
			{include file="engine/modules/calendar.php?mod=calendar"}
		</section>

		<section class="section">
			<header class="section-title"><span>خلاصه آمار سایت</span></header>
			{include file="engine/modules/siteinfo.php"}
		</section>

		<section class="section">
			<header class="section-title"><span>لینک دوستان</span></header>
			<ul>
				{include file="engine/modules/obmen.php"}
			</ul>
		</section>

	</aside>

	<section class="main">
		
		{info}
		{content}

	</section>

</div>

<footer>
	
	<div class="footer">

		<div class="wrapper">
		
			<div class="footer-column">
				
				<div class="footer-content">
				
					<h5><span>مطالب تصادفی</span></h5>

					<ul>
						{include file="engine/modules/3news.php?mod=randnews&template=randnews&from=0&limit=4"}
					</ul>
				
				</div>

			</div>
		
			<div class="footer-column">
				
				<div class="footer-content">
					
					<h5><span>تگ های مطالب سایت</span></h5>

					<div class="tags">
						{tags}
					</div>

				</div>

			</div>
		
			<div class="footer-column">
				
				<div class="footer-content">
					
					<h5><span>درباره سایت...</span></h5>

					<p class="justify">
						در این مکان می توانید توضیحی در رابطه با وب سایت خود بنویسید.<br/>جهت ویرایش این متن، به فایل <span class="en">main.tpl</span> قالب خود مراجعه کنید.
					</p>

				</div>

			</div>

		</div>

	</div>
	
	<div class="copyright">
		
		<div class="wrapper">

			<div class="right">
				سیستم قدرت گرفته از: <a href="http://www.datalifeengine.ir" target="_blank">دیتالایف انجین</a>
			</div>

			<div class="left">
				Copyright &copy; 2016 by Datalife Engine, All rights reserved.
			</div>

		</div>

	</div>

</footer>

</body>
</html>