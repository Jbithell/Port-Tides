# Porthmadog Tide Times

The fifth iteration of this site is a Tanstack Start App. Styling framework is Mantine. 

## Development

### VSCode

Two containers are provided - one is a Frontend container and the other is a PHP container. The Frontend container is used to run the Frontend development server and the PHP container is used to run the PHP script that generates the json tidal data and which generates the PDFs. A VSCode task is provided for running the build script. 

#### Connect to both containers in two VS Code windows

1. Open a VS Code window at the root level of the project.
1. Run Dev Containers: Reopen in Container from the Command Palette (F1) and select `Frontend Container`.
1. VS Code will then start up both containers, reload the current window and connect to the selected container.
1. Next, open a new window using File > New Window.
1. Open your project at root level in the current window.
1. Run Dev Containers: Reopen in Container from the Command Palette (F1) and select `PHP Container`.
1. The current VS Code window will reload and connect to the selected container.
1. You can now interact with both containers from separate windows.

#### Connect to multiple containers in a single VS Code window

1. Open a VS Code window at the root level of the project.
1. Run Dev Containers: Reopen in Container from the Command Palette (F1) and select `Frontend Container`.
1. VS Code will then start up both containers, reload the current window and connect to the selected container.
1. Run Dev Containers: Switch Container from the Command Palette (F1) and select `PHP Container`.
1. The current VS Code window will reload and connect to the selected container.
1. You can switch back with the same command

## Copyright Information 

All Tidal Data is ©Crown Copyright. Reproduced by permission of the Controller of Her Majesty's Stationery Office and the UK Hydrographic Office (www.ukho.gov.uk). No tidal data may be reproduced without the expressed permission of the UKHO Licencing Department.

Tidal Predictions are provided for use by all water users though the developers of this site can not be held accountable for the accuracy of this data or any accidents that result from the use of this data.