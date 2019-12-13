const { _x } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { ServerSideRender } = wp.components;
const { Component } = wp.element;

registerBlockType( 'acf/image-gallery', {
	title: _x( 'Image gallery', 'Block title', 'sha' ),
	icon: 'image-flip-horizontal',
	category: 'sht/blocks',
	supports: {
		mode: false,
		html: false,
		multiple: false,
		reusable: false
	},
	edit: class extends Component {
		render() {
			return (
				<ServerSideRender
					block="acf/image-gallery"
				/>
			);
		}
	},
	save() {
		return null;
	},
} );