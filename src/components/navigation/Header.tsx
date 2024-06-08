import { Container, Group, Burger, Image } from '@mantine/core';
import * as classes from './Header.module.css';
import React from 'react';
import { menuItems } from './menuItems';
import { Link } from 'gatsby';
import { useLocation } from '@reach/router';

export function Header({ menuOpened, menuToggle }: { menuOpened: boolean, menuToggle: () => void }) {
  const location = useLocation();
  const items = menuItems.map((link) => (
    <Link
      key={link.label}
      to={link.link}
      className={classes.link}
      data-active={location.pathname.replace(/\/$/, "") === link.link || undefined}
    >
      {link.label}
    </Link>
  ));

  return (

    <Container size="xl" className={classes.inner}>
      <Link to="/"></Link>
      <Group gap={5} visibleFrom="xs">
        {items}
      </Group>

      <Burger opened={menuOpened} onClick={menuToggle} hiddenFrom="xs" size="sm" />
    </Container>
  );
}