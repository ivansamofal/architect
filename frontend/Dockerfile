FROM node:18
WORKDIR /usr/src/app
COPY package*.json ./
RUN npm install
COPY . .
#RUN npm run build
EXPOSE 3000
#CMD ["npm", "run", "dev"]
#CMD ["node", "server.js"]
#CMD node server.js
CMD npm run dev && node server.js
