import * as classes from './Header.module.css';
import React from 'react';
import { menuItems } from './menuItems';
import { useLocation } from '@reach/router';
import { Link } from 'gatsby';

export function MobileNavbar() {
  const location = useLocation();
  return menuItems.map((link) => (
    <Link
      key={link.label}
      to={link.link}
      className={classes.link}
      data-active={location.pathname.replace(/\/$/, "") === link.link || undefined}
    >
      <span>{link.label}</span>
    </Link>
  ));
}