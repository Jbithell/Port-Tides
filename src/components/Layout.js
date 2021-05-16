import * as React from "react";
import Header from "../components/Header.js";
import Copyright from "../components/Copyright.js";

const Layout = ({ children, lang }) => {
  return (
    <body className="bg-gradient-to-br from-blue-100 to-blue-300  bg-no-repeat bg-cover flex flex-col min-h-screen">
      <Header lang={lang} />
      <main className="flex-grow">
        {children}
      </main>       
      <Copyright lang={lang} />
    </body>
  );
};

export default Layout;
