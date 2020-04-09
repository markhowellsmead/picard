import { Component } from '@wordpress/element';
import { RichText } from '@wordpress/block-editor';
import { _x } from '@wordpress/i18n';

export class BlockText extends Component {

	constructor( props ) {
		super( ...arguments );
		this.props = props;
	}

	render() {

		const { className, tagName, text, setAttributes } = this.props;

		const tag_name = tagName || 'div';
		const class_name = className || 'c-block__text';

		return (
			<RichText
				tagName = { tag_name }
				className = { class_name }
				format = "string"
				allowedFormats = {[]}
				formattingControls = {[]}
				placeholder = {_x('Add an excerpt in an alternative language…', 'Field placeholder', 'sha')}
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