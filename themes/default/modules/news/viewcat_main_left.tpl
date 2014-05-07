<!-- BEGIN: main -->
<!-- BEGIN: listcat -->
<div class="news_column">
	<div class="panel panel-default clearfix">
		<div class="panel-heading">
			<ul class="list-inline" style="margin: 0">
				<li><a title="{CAT.title}" href="{CAT.link}"><span>{CAT.title}</span></a></li>
				<!-- BEGIN: subcatloop -->
				<li class="hidden-xs"><a title="{SUBCAT.title}" href="{SUBCAT.link}">{SUBCAT.title}</a></li>
				<!-- END: subcatloop -->
				<!-- BEGIN: subcatmore -->
				<li class="pull-right hidden-xs"><a title="{MORE.title}" href="{MORE.link}"><em class="fa fa-sign-out">&nbsp;</em></a></li>
				<!-- END: subcatmore -->
			</ul>
		</div>
		
		<div class="clear">&nbsp;</div>
		<div class="panel-body">
			<div class="row">
				<!-- BEGIN: related -->
				<div class="col-md-4">
					<ul class="related">
						<!-- BEGIN: loop -->
						<li class="{CLASS}">
							<a class="show" title="<img class='img-thumbnail pull-left margin_image' src='{OTHER.imghome}' width='90' /><p class='text-justify'>{OTHER.hometext}</p><div class='clearfix'></div>" href="{OTHER.link}" rel="tooltip" data-toggle="tooltip" data-html="true" data-placement="bottom">{OTHER.title}</a>
						</li>
						<!-- END: loop -->
					</ul>
				</div>
				<!-- END: related -->
				
				<div class="{WCT}">
					<!-- BEGIN: image -->
					<a title="{CONTENT.title}" href="{CONTENT.link}"><img src="{HOMEIMG}" alt="{HOMEIMGALT}" width="{IMGWIDTH}" class="img-thumbnail pull-left imghome" /></a>
					<!-- END: image -->
					
					<h3>
						<a title="{CONTENT.title}" href="{CONTENT.link}">{CONTENT.title}</a>
						<!-- BEGIN: newday -->
						<span class="icon_new">&nbsp;</span>
						<!-- END: newday -->
					</h3>
					<p class="text-justify">{CONTENT.hometext}</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: listcat -->
<!-- BEGIN: tooltip -->
<script type="text/javascript">
    $(document).ready(function() {$("[rel='tooltip']").tooltip();});
</script>
<!-- END: tooltip -->
<!-- END: main -->