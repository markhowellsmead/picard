const { _x } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { ServerSideRender } = wp.components;
const { Component } = wp.element;

registerBlockType("mhm/years-online", {
	title: _x("Years online", "Block title", "sha"),
	icon: "image-flip-horizontal",
	category: "widgets",
	supports: {
		mode: false,
		html: false,
		multiple: true,
		reusable: true
	},
	edit: class extends Component {
		render() {
			return <ServerSideRender block="mhm/years-online" />;
		}
	},
	save() {
		return null;
	}
});
