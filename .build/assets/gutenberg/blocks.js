// import "./image-gallery/block.jsx";
import "./count-photos/index.jsx";
import "./count-posts/index.jsx";
import "./post-excerpt/index.jsx";
import "./shb-video-bar/index.jsx";
import "./years-online/index.jsx";

window.onload = function() {
	window.shtDisabledBlocks.forEach(block => {
		wp.blocks.unregisterBlockType(block);
	});
};

wp.domReady(() => {
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-21",
		label: "2:1",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-251",
		label: "2.5:1",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-31",
		label: "3:1",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-41",
		label: "4:1",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "aspect-169",
		label: "16:9",
	});
	wp.blocks.registerBlockStyle("core/cover", {
		name: "full-height",
		label: "Full height",
	});
	wp.blocks.registerBlockStyle("core/paragraph", {
		name: "lead",
		label: "Lead text",
	});
	wp.blocks.registerBlockStyle("shb/video-bar", {
		name: "fullheight",
		label: "Full screen height",
	});
});
