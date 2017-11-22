
( function( $ ) {

	gform.addFilter( 'gform_is_value_match', function( isMatch, formId, rule ) {

		var fieldValue   = false,
			ruleValue    = rule.value,
			$sourceInput = jQuery( '#input_' + formId + '_' + rule.fieldId ),
			isTimeField = $sourceInput.parents( 'li.gfield' ).hasClass( 'gcldf-field-time' );

		if( rule.fieldId == '_gpcld_current_time' || isTimeField ) {

			var currentDate = new Date(),
				$timeInputs = $sourceInput.parents( 'li.gfield' ).find( 'input, select' ),
				timeString  = '{0}:{1}{2}'.format( $timeInputs.eq( 0 ).val(), $timeInputs.eq( 1 ).val(), $timeInputs.eq( 2 ).val() );

			var datetime    = isTimeField ? getDateFromTimeString( timeString ) : currentDate,
				timestamp   = datetime.getTime() / 1000,
				compareDate = getDateFromTimeString( rule.value );

			/**
			 * Convert user's local time to UTC.
			 *
			 * @since 1.0.1
			 *
			 * @param bool   $enable Enable conversion of user's local time to UTC.
			 * @param object $rule   The current Gravity Forms rule object being evaluated.
			 * @param int    formId  The current form ID.
			 */
			if( gform.applyFilters( 'gpcld_enable_utc_timezone', false, rule, formId ) ) {

				var tzOffset    = datetime.getTimezoneOffset() * 60, // convert to seconds
					tzTimestamp = ( datetime.getTime() / 1000 ) - tzOffset,
					tzDatetime  = new Date( tzTimestamp * 1000 );

				timestamp = tzTimestamp;

			}


			ruleValue = ( compareDate.getTime() / 1000 );

		} else {

			if( ! $sourceInput.parents( 'li.gfield' ).hasClass( 'gcldf-field' ) ) {
				return isMatch;
			}

			// save the original value, will re-populate back into the field
			var origValue  = $sourceInput.val(),
				formatBits = getDateFormatByClass( $sourceInput.parents( 'li.gfield' ).attr( 'class' ) ).split( '_' ),
				mdy        = formatBits[0] ? formatBits[0] : 'mdy',
				sepTypes   = { dot: '.', slash: '/', dash: '-' },
				separator  = formatBits[1] ? sepTypes[ formatBits[1] ] : '/',
				dateBits   = origValue.split( separator ),
				month      = dateBits[ mdy.indexOf( 'm' ) ] - 1,
				day        = dateBits[ mdy.indexOf( 'd' ) ],
				year       = dateBits[ mdy.indexOf( 'y' ) ];

			var date      = new Date( year, month, day, 0, 0, 0, 0 ),
				tzOffset  = date.getTimezoneOffset() * 60, // convert to seconds
				timestamp = ( date.getTime() / 1000 ) - tzOffset;

			if( isNaN( timestamp ) ) {
				timestamp = false;
			}

		}

		/*
		 * Allows use of asterisks (wildcards) when specifying dates in rule values. Will be replaced with
		 * the corresponding value from the compared date value.
		 *
		 * Selected Date: 9/20/2016
		 * Wildcard Rule: 9/15/*
		 * Replaced Rule: 9/15/2016
		 */
		if( String( ruleValue ).indexOf( '*' ) != -1 ) {

			var ruleBits   = ruleValue.split( '/' ),
				origValue  = $sourceInput.val(),
				formatBits = getDateFormatByClass( $sourceInput.parents( 'li.gfield' ).attr( 'class' ) ).split( '_' ),
				mdy        = formatBits[0] ? formatBits[0] : 'mdy',
				sepTypes   = { dot: '.', slash: '/', dash: '-' },
				separator  = formatBits[1] ? sepTypes[ formatBits[1] ] : '/',
				dateBits   = origValue.split( separator ),
				month      = dateBits[ mdy.indexOf( 'm' ) ],
				day        = dateBits[ mdy.indexOf( 'd' ) ],
				year       = dateBits[ mdy.indexOf( 'y' ) ],
				dateBits   = [ month, day, year ];

			for( var i = 0; i < ruleBits.length; i++ ) {
				if( ruleBits[i] == '*' ) {
					ruleBits[i] = dateBits[i];
				}
			}

			// ruleBits = [ month, day, year ]
			var date      = new Date( ruleBits[2], ruleBits[0] - 1, ruleBits[1], 0, 0, 0, 0 ),
				tzOffset  = date.getTimezoneOffset() * 60; // convert to seconds

			ruleValue = ( date.getTime() / 1000 ) - tzOffset;

		}

		// modify timestamp or _rule.value so that rule always returns false until a date is selected
		if( timestamp === false ) {
			if( rule.operator == 'isnot' ) {
				timestamp = ruleValue;
			} else if( rule.operator != 'is' ) {
				ruleValue = '';
			} else {
				timestamp = 0;
			}
		}

		fieldValue = timestamp;

		var tag = rule.value.match( /{(.+?)}/ );

		if( tag ) {

			var tag  = tag[1].toLowerCase(),
				days = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];

			switch( tag ) {
				case 'monday':
				case 'tuesday':
				case 'wednesday':
				case 'thursday':
				case 'friday':
				case 'saturday':
				case 'sunday':
					fieldValue = isNaN( date.getDay() ) ? '' : date.getDay();
					ruleValue  = days.indexOf( tag );
					break;
			}

		}

		// must be strings for GF
		isMatch = gf_matches_operation( String( fieldValue ), String( ruleValue ), rule.operator );

		return isMatch;
	} );

	function getDateFromTimeString( timeString ) {

		var bits        = timeString.split( /([0-9]{1,2}):([0-9]{2})(am|pm)?/ ), // 09:00pm => [ '', '09', '00', 'pm', '' ]
			hour        = parseInt( bits[1] ),
			min         = parseInt( bits[2] ),
			ampm        = bits[3],
			currentDate = new Date();

		if( ampm == 'pm' && hour != 12 ) {
			hour += 12;
		} else if( ampm == 'am' && hour == 12 ) {
			hour = 0;
		}

		return new Date( currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate(), hour, min, 0, 0 );
	}

	function getDateFormatByClass( cssClass ) {
		var classes = cssClass.split( ' ' );
		for( var i = 0; i < classes.length; i++ ) {
			if( classes[i].indexOf( 'gcldf-date-format-' ) != -1 ) {
				var bits = classes[i].split( '-' );
				return bits[ bits.length - 1 ];
			}
		}
		return false;
	}

} )( jQuery );