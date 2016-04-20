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
	
	$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	
	$('#title-recipe').on('click', function() {
		sorter = "title";
		clean_list(); 
		$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	});
	$('#category-recipe').on('click', function() {
		sorter = "category";
		clean_list(); 
		$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	});
	$('#duration-recipe').on('click', function() {
		sorter = "duration";
		clean_list(); 
		$.get(uri + "/" + sorter + '/' + page + '/' + categories, update_list);
	});
	$('#rating-recipe').on('click', function() {
		sorter = "rating";
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
		
	}
});