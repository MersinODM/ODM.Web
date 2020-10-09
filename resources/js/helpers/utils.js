/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */

import { createPopper } from '@popperjs/core/dist/umd/popper.min'

const range = (start, end) => Array.from(
  Array(Math.abs(end - start) + 1),
  (_, i) => start + i
)

const calculateWithPopper = (dropdownList, component, { width }) => {
  /**
   * We need to explicitly define the dropdown width since
   * it is usually inherited from the parent with CSS.
   */
  dropdownList.style.width = width

  /**
   * Here we position the dropdownList relative to the $refs.toggle Element.
   *
   * The 'offset' modifier aligns the dropdown so that the $refs.toggle and
   * the dropdownList overlap by 1 pixel.
   *
   * The 'toggleClass' modifier adds a 'drop-up' class to the Vue Select
   * wrapper so that we can set some styles for when the dropdown is placed
   * above.
   */
  const popper = createPopper(component.$refs.toggle, dropdownList, {
    placement: 'top',
    modifiers: [
      {
        name: 'offset',
        options: {
          offset: [0, -1]
        }
      },
      {
        name: 'toggleClass',
        enabled: true,
        phase: 'write',
        fn ({ state }) {
          component.$el.classList.toggle('drop-up', state.placement === 'top')
        }
      }]
  })

  /**
   * To prevent memory leaks Popper needs to be destroyed.
   * If you return function, it will be called just before dropdown is removed from DOM.
   */
  return () => popper.destroy()
}

export {
  range,
  calculateWithPopper
}
