/**
 * 
 */
$(function() {
	var page = 1;;
	var categories = "All";
	var sorter = "alpha";
	
	var uri = $("#body-list").data("uri");
	var uriShow = $("#body-list").data("uri-show").split('0')[1];
	var $layer = $("#layer-recipe-item")
	$.get(uri + "/" + sorter + '/' + page + '/' + categories, function(data) {
		console.log(data);
		var recipes = data.recipes;
		for (var i = 0; i < recipes.length; i++) {
			var $item = $layer.clone();
			$item.attr('id', "recipe-item-" + i);
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
	})
});