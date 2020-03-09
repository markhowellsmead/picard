const { _x } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { ServerSideRender } = wp.components;
const { Component } = wp.element;

registerBlockType("mhm/count-photos", {
	title: _x("Number of photos", "Block title", "sha"),
	icon: "image-flip-horizontal",
	category: "widgets",
	supports: {
		mode: false,
		html: false,
		multiple: true,
		reusable: true
	},
	keywords: ["count", "photos"],
	edit: class extends Component {
		render() {
			return <ServerSideRender block="mhm/count-photos" />;
		}
	},
	save() {
		return null;
	}
});
