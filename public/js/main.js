$(function(){
	
	// Configuramos el Focus para los INPUT y los TEXTAREA
	$('input:text, textarea')
	.focus(function(){
		$id = $(this).attr('id');
		$('#'+$id+'-element, #'+$id+'-label')
			.addClass('focused')
			.find('.description').fadeIn();
	})
	.blur(function(){
		$id = $(this).attr('id');
		$('#'+$id+'-element, #'+$id+'-label')
			.removeClass('focused')
			.find('.description').fadeOut();
	});
		
	// Asignamos las votaciones
	$('.puntuacion a').click(function(e)
	{
		$this = $(this);
		if($this.hasClass('disabled')) return false;
		opcion = $this.attr('class');
		$this.parent().find('a').addClass('disabled');
		$id = $this.parent('.puntuacion').attr('id').substr(4);
		$.ajax({
			url: '/ideas/puntuar',
			type: 'POST',
			dataType: 'json',
			data: {'id': $id, 'opcion': opcion},
			success: function(data, textStatus) {
				$span = $this.parent('.puntuacion').find('span');
				$span.fadeOut('fast', function() {
					$span
						.removeClass()
						.addClass(opcion)
						.html(data.value)
						.fadeIn('fast');
				});
			}
		});
		e.preventDefault();
	});
});