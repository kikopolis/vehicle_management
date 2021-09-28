document.addEventListener('DOMContentLoaded', () => {
	const selectDivs = document.querySelectorAll('.select');
	const selectElems = document.querySelectorAll('select');
	
	function createSelects() {
		for (let i = 0; i < selectDivs.length; i++) {
			for (let j = 0; j < selectElems.length; j++) {
				if (selectDivs[i].contains(selectElems[j])) {
					selectDivs[i].append(createPseudoSelects(selectElems[j]));
				}
			}
			selectDivs[i].addEventListener('mouseenter', event => {
				const select = event.target.querySelector('.select__options--list');
				select.style.display = 'block';
				setTimeout(() => {
					select.classList.add('expanded');
				}, 1);
			});
			selectDivs[i].addEventListener('mouseleave', event => {
				const select = event.target.querySelector('.select__options--list');
				select.classList.remove('expanded');
				setTimeout(() => {
					select.style.display = 'none';
				}, 200);
			});
		}
	}
	
	function createPseudoSelects(select) {
		const elem = document.createElement('div');
		elem.className = 'select__options--list';
		for (let i = 0; i < select.options.length; i++) {
			const opt = document.createElement('div');
			opt.className = 'select__option';
			opt.dataset.value = select.options[i].value;
			if (select.options[i].selected) {
				opt.classList.add('select__option--selected');
			}
			const span = document.createElement('span');
			span.className = 'select__option--text';
			span.innerText = select.options[i].innerText;
			if (select.options[i].selected) {
				span.classList.add('select__option--selected');
			}
			opt.addEventListener('click', event => selectOption(event.target));
			span.addEventListener('click', event => selectOption(event.target));
			opt.appendChild(span);
			elem.appendChild(opt);
		}
		return elem;
	}
	
	function selectOption(target) {
		if (! target) {
			return;
		}
		// Whatever part is clicked, make sure the option div itself is considered as the target
		if (! target.classList.contains('select__option')) {
			return selectOption(target.parentElement);
		}
		const parents = getParents(target);
		// todo here loop the select elements list and select the matching option
		let select;
		for (let i = 0; i < parents.length; i++) {
			if (parents[i].classList.contains('select')) {
				select = parents[i].querySelector('select');
				break;
			}
		}
		if (typeof select === undefined) {
			return;
		}
		// Loop the hidden select and match the clicked option
		for (let i = 0; i < select.options.length; i++) {
			if (target.dataset.value === select.options[i].value) {
				select.options[i].selected = true;
			} else {
				select.options[i].selected = false;
			}
		}
		// Loop through the pseudo element children to set their styles to match new selection
		let visibleSelect;
		for (let i = 0; i < parents.length; i++) {
			if (parents[i].classList.contains('select')) {
				visibleSelect = parents[i].querySelector('.select__options--list');
				break;
			}
		}
		if (typeof visibleSelect === undefined) {
			return;
		}
		for (let i = 0; i < visibleSelect.children.length; i++) {
			if (visibleSelect.children[i].dataset.value === target.dataset.value) {
				visibleSelect.children[i].classList.add('select__option--selected');
			} else {
				visibleSelect.children[i].classList.remove('select__option--selected');
			}
		}
	}
	
	function getParents(element) {
		let parents = [];
		for (; element && element !== document.body; element = element.parentElement) {
			parents.push(element);
		}
		return parents;
	}
	
	createSelects();
});