<article class="section" id="fullnews">
	
	<header class="oh">

		<div class="fullnews-date">
			<span>{date=m/j}</span>
			{date=Y}
		</div>

		<div class="left">

			[rating]
			[rating-type-1]<div class="ratebox"><div class="rate">{rating}</div></div>[/rating-type-1]
			[rating-type-2]<div class="ratebox2">
			<ul class="reset">
			<li>[rating-plus]<img src="{THEME}/images/like.png" title="Like" alt="Like" style="width:14px;" />[/rating-plus]</li>
			<li>{rating}</li>
			</ul></div>[/rating-type-2]
			[rating-type-3]<div class="ratebox3">
			<ul class="reset">
				<li>[rating-minus]<img src="{THEME}/images/ratingminus.png" title="امتیاز منفی" alt="امتیاز منفی" style="width:14px;" />[/rating-minus]</li>
				<li>{rating}</li>
				<li>[rating-plus]<img src="{THEME}/images/ratingplus.png" title="امتیاز مثبت" alt="امتیاز مثبت" style="width:14px;" />[/rating-plus]</li>
			</ul>
			</div>[/rating-type-3]
			[/rating]

		</div>

		<div class="section-main-title">
			<h3><span>[full-link]{title}[/full-link]</span></h3>
		</div>

	</header>

	<p>
		{full-story}
	</p>

	<footer class="section-footer news-footer">
		
		<div class="right">دسته بندی: {link-category}</div>
		<div class="left">
			 <span>بازدیدها: <strong>{views}</strong></span>
			 <span>نظرات: <strong>{comments-num}</strong></span>
			 <span>نویسنده: {author}</span>
		</div>

	</footer>

</article>

{comments}
{navigation}
{addcomments}