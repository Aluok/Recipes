/**
 * 
 */
$(function() {
	var page = 1;;
	var categories = "All";
	var sorter = "title";
	
	var uri = $("#body-list").data("uri");
	var uriShow = $("#body-list").data("uri-show").split('0')[1];
	var $layer = $("#layer-recipe-item");
	var last_page = $('.pagination > li:last-child > a').data('page');
	
	$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	update_pagination();
	
	$('.pagination > li > a').on('click', function(e) {
		e.preventDefault();
		var classname = $(this).closest('li').attr('class');
		if (classname == undefined || classname.indexOf('disabled') == -1) {
//			var page = $('.pagination > li > a.current').data('page');

			console.log($(this));
			switch ($(this).data('action')) {
			case 'first':
				console.log('f');
				page = 1;
				break;
			case 'previous':
				console.log('p');
				page--;
				break;
			case 'next':
				console.log('n');
				page++; 
				break;
			case 'last':
				console.log('l');
				page = last_page;
				break;
			}
			console.log(page);
			li_list = $('.pagination > li');
			

//			$('.pagination > li > a.current').text(page).data('page', page);
			clean_list();
			$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
		}
	});
	
	$('#title-recipe').on('click', function() {
		sorter = "title";
		page = 1;
		clean_list(); 
		$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	});
	$('#category-recipe').on('click', function() {
		sorter = "category";
		page = 1;
		clean_list(); 
		$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	});
	$('#duration-recipe').on('click', function() {
		sorter = "duration";
		page = 1;
		clean_list(); 
		$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	});
	$('#rating-recipe').on('click', function() {
		sorter = "rating";
		page = 1;
		clean_list(); 
		$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	});
	
	
	function clean_list() {
		$("#body-list").find('tr.recipe-item').remove();
	}
	
	function update_list(data) {
		var recipes = data.recipes;
		for (var i = 0; i < recipes.length; i++) {
			var $item = $layer.clone();
			$item.attr('id', "recipe-item-" + i)
				.attr('class', 'recipe-item');
			$item.find(".recipe-title > a")
				.text(recipes[i].title)
				.attr("href", uriShow + recipes[i].slug);
			$item.find(".recipe-category")
				.text(recipes[i].category);
			var time = recipes[i].duration.date.split(" ")[1].split(":");
			$item.find(".recipe-duration")
				.text(time[0] + ' h ' + time[1]);
			$item.find(".recipe-rating")
				.text(recipes[i].rating);
			$("#body-list").append($item);
		}

		$('.pagination > li > a.current').text(page).data('page', page);
		if (page == 1) {
			$(li_list[0]).addClass('disabled');
			$(li_list[1]).addClass('disabled');
			$(li_list[3]).removeClass('disabled');
			$(li_list[4]).removeClass('disabled');
		} else if (page == last_page) {
			$(li_list[0]).removeClass('disabled');
			$(li_list[1]).removeClass('disabled');
			$(li_list[3]).addClass('disabled');
			$(li_list[4]).addClass('disabled');
		} else {
			$(li_list[0]).removeClass('disabled');
			$(li_list[1]).removeClass('disabled');
			$(li_list[3]).removeClass('disabled');
			$(li_list[4]).removeClass('disabled');
		}
	}
	
	function update_pagination() {
		$('.pagination').show();
		$('.pagination .current').text($("#body-list").data("page"));
	}
	
});