/**
 * Part of csi project.
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

;(function($)
{
	"use strict";

	window.Webometrics = window.Webometrics || {

		/**
		 * Fetch webometrics.
		 */
		fetchWebometrics: function()
		{
			$('.webo-result').each(function()
			{
				var row = $(this);

				var url = row.attr('data-url');

				$.ajax({
					url: 'index.php?option=com_csi&task=result.ajax.webometrics&url=' + url,
					dataType: 'JSON',
					success: function(result)
					{
						if (result.success)
						{
							row.html(result.data.count);
						}
						else
						{
							row.html('-');
						}
					}
				});
			});
		}
	};
})(jQuery);
