[searchposts]
[fullresult]
<article class="section">
	
	<header class="section-main-title">
		<h3><span>[full-link]{title}[/full-link]</span></h3>
	</header>

	<p>
		{short-story}

		<div class="taleft">
			<a href="{full-link}" class="read-more">ادامه مطلب</a>
		</div>
	</p>

	<footer class="section-footer news-footer">
		
		<div class="right">دسته بندی: {link-category}</div>
		<div class="left">
			 <span>تاریخ: <strong>{date=d M Y}</strong></span>
			 <span>نظرات: <strong>{comments-num}</strong></span>
			 <span>نویسنده: {author}</span>
		</div>

	</footer>

</article>
[/fullresult]
[shortresult]
<div class="dpad searchitem">
	<h3>[full-link]{title}[/full-link]</h3>
	<b>[day-news]{date}[/day-news]</b> | {link-category} | Author: {author}
</div>
[/shortresult]
[/searchposts]
[searchcomments]
[fullresult]
<div class="comments">
	
	<div class="cm-info">
		<div class="avatar"><img src="{foto}" alt=""/></div>
		<span>{group-name}</span>

		<br/>
		[com-edit]<img src="{THEME}/images/edit.png" title="ویرایش" alt="" />[/com-edit]
		[com-del]<img src="{THEME}/images/trash.png" title="حذف" alt="" />[/com-del]
		[complaint]<img src="{THEME}/images/complaint.png" title="گزارش به مدیر" alt="" />[/complaint]
		[spam]<img src="{THEME}/images/spam.png" title="اسپم" alt="" />[/spam]
	</div>

	<div class="section">
		[fast]<span class="reply">پاسخ</span>[/fast]
		<span class="date">{date}</span>
		<span class="author">{author}</span>
		{comment}
		[signature]<br clear="all" /><div class="signature">--------------------</div><div class="slink">{signature}</div>[/signature]
	</div>

</div>
[/fullresult]
[shortresult]
<div class="dpad searchitem">
	<h3 style="margin-bottom: 0.4em;">{news_title}</h3>
	<b>{date}</b> | Author: {author}
</div>
[/shortresult]
[/searchcomments]