import * as React from "react";

// markup
const NotFoundPage = () => {
  const lang = location.pathname.includes("/cy") ? "cy" : "en";
  return (
    <main>
      <title>Not found</title>
      {lang == "en" ?
        <h1>404 - Page not found</h1>
        :
        <h1>404 - Tudalen heb ei darganfod</h1>
      }
    </main>
  );
};

export default NotFoundPage;
