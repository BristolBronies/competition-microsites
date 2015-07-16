var app = app || {};

app.entryForm = {
	init: function() {
		this.clearErrors();
		this.prepareForm();
	},
	prepareForm: function() {
		var self = this;
		$("[data-form]").ajaxForm({
			dataType: "json",
			beforeSubmit: function() {
				self.clearErrors();
			},
			success: function(responseText, statusText, xhr, $form) {
				if(responseText.success != undefined) {
					$form.resetForm();
					window.location.reload(true);
				}
				else {
					$.each(responseText.fields, function(i, value) {
						console.log(i, value);
						if(value[0] == "form") {
							$("[data-error='" + value[1] + "']").show();
						}
						else {
							var $field = $("[name='" + value[0] + "']");
							$field.addClass("form__input--error");
							$field.closest(".form__controls").find("[data-error='" + value[1] + "']").show();
						}
					});
				}
			},
			error: function() {
				$("[data-error='nodata']").show();
			}
		});
	},
	clearErrors: function() {
		$("[data-error]").hide();
		$(".form__input--error").removeClass(".")
	}
}

$(document).ready(function() {
	app.entryForm.init();
});