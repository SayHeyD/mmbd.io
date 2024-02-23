import {expect, test} from '@playwright/test';
import common from './common';

test('The index page loads', async ({ page, context }) => {
    await page.goto(`${common.appUrl}`);
    await expect(page.getByRole('heading', { name: 'mmbd.io' })).toBeVisible();
    // await page.getByText('Does your grandma get').click();
    // await page.getByText('Paste the link to the post').click();
    // await page.getByRole('button', { name: 'Get your link!' }).click();
    // await page.getByRole('link', { name: 'How it works' }).click();
});
