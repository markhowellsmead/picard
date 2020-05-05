import { Component } from '@wordpress/element';
import { RichText } from '@wordpress/block-editor';
import { _x } from '@wordpress/i18n';

export class BlockText extends Component {

	constructor( props ) {
		super( ...arguments );
		this.props = props;
	}

	render() {

		const { className, placeHolder, tagName, text, setAttributes } = this.props;

		const tag_name = tagName || 'div';
		const class_name = className || 'c-block__text';
		const place_holder = placeHolder || _x('Add an excerpt in an alternative language…', 'Field placeholder', 'sha');

		return (
			<RichText
				tagName = { tag_name }
				className = { class_name }
				format = "string"
				allowedFormats = {['core/bold', 'core/italic', 'core/link']}
				formattingControls = {[]}
				placeholder = {placeHolder}
				multiline = "p"
				value = { text }
				keepPlaceholderOnFocus = { true }
				onChange = {value => {
					setAttributes({text: value});
				}}
			/>
		);
	}
}
