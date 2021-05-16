import * as React from "react";
import Header from "../components/Header.js";
import Tides from "../components/Tides.js";
import PDFs from "../components/PDFs.js";
import Copyright from "../components/Copyright.js";
const IndexPage = () => {
  return (
    <body className=" bg-header-image bg-no-repeat bg-cover flex flex-col min-h-screen">
      <Header lang="cy" />
      <main className="flex-grow">
        <Tides lang="cy" />
        <PDFs lang="cy" />  
        
      </main>       
      <Copyright lang="cy" />
    </body>
  );
};

export default IndexPage;
